<?php
namespace App\Controllers;
use App\Models\RolesModel;

class RolesController extends BaseController
{
    public $role;

    public function __construct()
    {
        $this->role = new RolesModel();
    }

    public function getRoles()
    {
        $roles = $this->role->getAllRoles();
        $this->render('roles.listRoles',['roles' => $roles]);
    }
    public function createRoles()
    {
        $this->render('roles.addRoles');
    }
    public function postRoles()
    {
        $error = [];
        if(empty($_POST['name'])){
            $error['name'] = "Vui long dien ten chuc nang";
        }
        if(count($error)>= 1){
            redirect('error',$error,'add-roles');
        }else{
            $check = $this->role->addRoles(null, $_POST['name']);
            if($check){
                redirect('success', 'Them thanh cong', 'list-roles');
            }
        }
    }
    public function detailRoles($id)
    {
        $detail = $this->role->getRolesById($id);
        $this->render('roles.editRoles',compact('detail'));
    }
    public function editRoles($id)
    {
        if(isset($_POST['btn-submit'])){
            $error = [];
            if(empty($_POST['name'])){
                $error ['name'] = "Vui long dien ten chuc nang";
            }
            $route = 'detail-roles/' . $id;
            if(count($error)>=1){
                redirect('error',$error,$route);
            }else{
                $check = $this->role->updateRoles($id, $_POST['name']);
                if($check){
                    redirect('success', 'cap nhat thanh cong', 'list-roles');
                }
            }
            
        }
    }
    public function deleteRoles($id)
    {
        $check = $this->role->deleteRoles($id);
        if($check){
            redirect('success', 'xoa thanh cong', 'list-roles');
        }
    }
}