<?php
namespace app\widgets;
use Yii;
class Datatable
{
	public $alias;//db alias
	function setAlias($alias)
	{
		$this->alias=$alias;
		return $this;
	}
	function run($model,$req,$columns)
	{
		$query = $model;

		//limit
        $query->limit($req['length'])->offset($req['start']);

		//get index of columns
		$columns_index=self::pluck($columns,'index');
		//get field of columns
        $columns_field=self::pluck($columns,'cond');
		//get field of select
		$select_field=self::pluck($columns,'select');

		//order start
        if(isset($req['order']) && count($req['order'])>0){
            $order_by=[];
            for($i=0; $i<count($req['order']); $i++){
                //get index column from order
                $column_order_index = intval($req['order'][$i]['column']);
                //get data from columns
                $column_order_request = $req['columns'][$column_order_index];
                //get value from 'data' columns
                $column_index = array_search($column_order_request['data'],$columns_index);
                $column = $columns[$column_index];
                if($column_order_request['orderable'] == 'true'){
					$dir = $req['order'][$i]['dir'] === 'asc' ? SORT_ASC:SORT_DESC;
					$order_by[$column['cond']] = $dir;
				}
            }
            if(count($order_by)>0){
                $query->orderBy($order_by);
            }
        }
        //order end

		//global search start
		$global_search = [];
        if(isset($req['search']) && $req['search']['value']!=''){
            $str = $req['search']['value'];
            for($i=0; $i<count($req['columns']); $i++){
				$column_request = $req['columns'][$i];
				$column_index = array_search( $column_request['data'],$columns_field);
				$column = $columns[$column_index];
				if($column_request['searchable']=='true'){
					if(!empty($column['cond'])){
                        //check n format field type date for pg
						if(isset($column['type']) && $column['type']=='date'){
							$global_search[]=['like',"TO_CHAR(".$column['cond']." :: DATE,'YYYY-MM-DD')",$str];
						}else{
							$global_search[]=['like',$column['cond'],$str];
						}
                    }
				}
			}
        }
		if(count($global_search)>0){
            $gs=array_merge(['OR'],$global_search);
            $query->where($gs);
        }
        //global search end

		//column search start
		$column_search= [];
        if(isset($req['columns'])){
			for ( $i=0; $i<count($req['columns']); $i++){
				$column_request = $req['columns'][$i];
				$column_index = array_search( $column_request['data'],$columns_field);
				$column = $columns[$column_index];
				$str = $column_request['search']['value'];
				if($column_request['searchable'] == 'true' && $str != '' ){
					if(!empty($column['cond'])){
                        //check n format field type date for pg
                        if(isset($column['type']) && $column['type']=='date'){
                            $column_search[]=['like',"TO_CHAR(".$column['cond']." :: DATE,'YYYY-MM-DD')",date('Y-m-d',strtotime($str))];
                        }else{
                            $column_search[]=['like',$column['cond'],$str];
                        }
					}
				}
			}
		}
		
        $cs=array_merge(['AND'],$column_search);
        if(count($column_search)>0){
            if(count($global_search)>0){
                $query->andWhere($cs);
            }else{
                $query->where($cs);
            }
        }
		//column search end

        $query->select($select_field)->notDeleted($this->alias);
        $data_filter_length=$query->count();
        $data_length=$model->notDeleted($this->alias)->count();
        $data=$query->asArray()->all();
        // echo $query->createCommand()->getRawSql(); exit;
        $result=[
			"draw"=> isset ($req['draw']) ? intval($req['draw']) : 0,
			"recordsTotal"=>intval($data_length),
			"recordsFiltered"=> intval($data_filter_length),
			"data"=>self::output($columns,$data)
        ];
		return $result;
	}
	static function pluck($columns,$prop)
	{
		$data=[];
        for($i=0; $i<count($columns); $i++){
            if(empty($columns[$i][$prop]) && $columns[$i][$prop]!=0){
                continue;
			}
			$data[$i] = $columns[$i][$prop];
		}
        return $data;
	}
	static function output($columns,$data)
	{
		$out = [];
		for($i=0; $i<count($data); $i++){
			$row = [];
			for($j=0; $j<count($columns); $j++){
				$column = $columns[$j];
				// Is there a formatter?
				if(isset($column['formatter'])){
                    if(empty($column['column'])){
                        $row[ $column['column'] ] = $column['formatter']( $data[$i] );
                    }
                    else{
                        $row[ $column['column'] ] = $column['formatter']( $data[$i][ $column['column'] ], $data[$i] );
                    }
				}else{
                    if(!empty($column['column'])){
                        $row[ $column['column'] ] = $data[$i][ $columns[$j]['column'] ];
                    }
                    else{
                        $row[ $column['column'] ] = "";
                    }
				}
			}
			$out[] = $row;
		}
		return $out;
	}
}
