<?php

class Role extends dbobject
{
   public function role_list($data)
    {
		$table_name    = "role";
		$primary_key   = "role_id";
		$columner = array(
			array( 'db' => 'role_id', 'dt' => 0 ),
			array( 'db' => 'role_id', 'dt' => 1 ),
			array( 'db' => 'role_name',  'dt' => 2 ),
			array( 'db' => 'created',     'dt' => 3, 'formatter' => function( $d,$row ) {
						return $d;
					}
				),
            array('db' => 'role_id', 'dt' => 4, 'formatter' => function($d,$row){
                return '<a class="btn btn-warning" onclick="getModal(\'setup/role_setup.php?op=edit&role_id='.$d.'\',\'modal_div\')"  href="javascript:void(0)" data-toggle="modal" data-target="#defaultModalPrimary">Edit Role</a> | <a class="btn btn-danger" onclick="deleteRole(\''.$d.'\')"  href="javascript:void(0)" >Delete Role</a>';
            })
			);
		$filter = "";
//		$filter = " AND role_id='001'";
		$datatableEngine = new engine();
	
		echo $datatableEngine->generic_table($data,$table_name,$columner,$filter,$primary_key);

    }
    public function saveRole($data)
    {
        $validation = $this->validate($data,array('role_name'=>'required','role_enabled'=>'required|int'),array('role_name'=>'Role Name','role_enabled'=>'Enable Role'));
        if(!$validation['error'])
        {
            $data['created'] = date('Y-m-d h:i:s');
            
            
            if($data['operation'] == "new")
            {
                $data['role_id'] = $this->getNextRoleId();
                // $data['role_enabled'] = "1";
                $count = $this->doInsert('role',$data,array('op','operation','id'));
                if($count > 0)
                {
                    return json_encode(array('response_code'=>0,'response_message'=>'Role Created Successfully')); 
                }else
                {
                    return json_encode(array('response_code'=>291,'response_message'=>'Role Could not be Created'));
                }
            }else
            {
                // var_dump($data);
                // exit;
                $name = $data['role_name'];
                $status = $data['role_enabled'];
                $id = $data['id'];
                // $count = $this->doUpdate('role',$data,array('role_id'=>$data['role_id']), array('op', 'operation', 'id', 'created'));
                // var_dump($count);
                $DSQL = "UPDATE role SET role_name = '$name', role_enabled = '$status' WHERE role_id = '$id'";
                 $count = $this->db_query($DSQL,false);
                if($count > 0)
                {
                    return json_encode(array('response_code'=>0,'response_message'=>'Role Update Successfully')); 
                }else
                {
                    return json_encode(array('response_code'=>291,'response_message'=>'Role Could not be Updated'));
                }
            }
            
        }
        else
        {
            return json_encode(array("response_code"=>34,"response_message"=>$validation['messages'][0]));
        }
    }
    public function getNextRoleId()
    {
        $sql    = "select CONCAT('00',max(role_id) +1) as rolee FROM role";
        $result = $this->db_query($sql);
        return $result[0]['rolee'];
        
    }
    public function deleteRole($data)
    {
       
        $role_id = $data['role_id'];
        $sql     = "DELETE FROM role WHERE role_id = '$role_id'";
        $this->db_query($sql,false);
        return json_encode(array('response_code'=>0,'response_message'=>'Deleted Successfully')); 
    }
}