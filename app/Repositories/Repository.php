<?php
namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Repository
{
    /**
     * @param $model
     * @param array $search 定义需要搜索的列名
     * @param \Closure|null $closure
     * @param \Closure|null $trans
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getSearchAbleData($model, array $search = [], \Closure $closure = null, \Closure $trans = null)
    {
        // sort 比如可以传 'id|desc'
        // 即代表 以 id 这一列进行 desc 方式的排序
        $data = requestOnly([
            'keyword', 'sort', 'page_size', 'exact_columns', 'where_in'
        ]);

        list($filter, $order, $pageSize, $exactColumns) = array_values($data);
        if (empty($exactColumns)) {
            $exactColumns = [];
        }

        if (!is_object($model)) {
            $model = app($model);
        }
        if (!$model instanceof Model) {
            throw new \UnexpectedValueException(__METHOD__ . ' expects parameter 1 to be an object of ' . Model::class . ',' . get_class($model) . ' given');
        }
        $orderArr = explode('|', $order, 2);

        $table = $model->getTable();

        $builder = $model->newQuery();
        if ($filter && $search) {
            $builder->where(function ($builder) use ($search, $filter, $table, $exactColumns) {
                foreach ((array)$search as $column) {
                    $columnArr = explode('.', $column);
                    if (count($columnArr) == 2) {
                        $table = $columnArr[0];
                        $column = $columnArr[1];
                    }
                    if (in_array($column, $exactColumns)) {
                        $builder->orWhere($table . '.' . $column, '=', $filter);
                    } else {
                        $builder->orWhere($table . '.' . $column, 'like', "%{$filter}%");
                    }
                }
            });
        }
        if ($closure) {
            $closure($builder);
        }

        $key = $model->getKeyName();
        list($o, $d) = [
            array_get($orderArr, 0) ?: $table . '.' . $key,
            array_get($orderArr, 1) ?: 'desc'
        ];
        $builder->orderBy($o, $d);

        $url = url()->current();

        $query = \Request::query();
        $query = http_build_query(array_except($query, 'page'));

        /** @var LengthAwarePaginator $pager */
        $pager = $builder->paginate($pageSize ?: 10)->setPath($url . '?' . $query);

        if ($trans) {
            $trans($pager->getCollection());
        }

        return $pager;
    }
}
