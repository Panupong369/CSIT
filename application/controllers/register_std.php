<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register_std extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Student');  //ทำการload model student เข้ามาใช้งาน
        $this->load->model('Fac_Model');
        $this->load->helper('url');
    }

    /**
      ส่วนของcontroller  login ทำงานเป็นส่วนแรกของระบบในการตรวจสอบการทำงาน
      function indexเรียกหน้า login ใน front/login
     */
    public function index() {
        $this->load->view('front/frm_std1');
    }

    function upload_img($std_id = null) {
        $this->load->view('front/frm_upload_img', $std_id);
    }

    function do_upload() {
        /* function save image ใช้ในการเก็บรูปภาพเข้าไปใน asset/images/img_std
         * ระบบจะทำการเปลี่ยนชื่อภาพเป็นรหัสนักศึกษาและเก็บ path รูปไว้ใน tb_student->path
         */
        $name = $this->input->post('std_id'); //เอา std_id มาเป็นชื่อของภาพ

        $type = explode('.', $_FILES["std_img"]["name"]); // แยกชื่อภาพกันนามสกุลภาพออกจากกันโดยการหา . เป็นตัวแบ่ง
        $type = $type[count($type) - 1];
        if (is_uploaded_file($_FILES["std_img"]["tmp_name"])) {
            move_uploaded_file($_FILES["std_img"]["tmp_name"], "./assets/images/img_std/" . $name . '.' . $type);

            //echo $img_path = base_url('/assets/images/img_std/' . $name . '.' . $type);
            echo"<br><br>";
            $path_img = ($name . '.' . $type);  //เก็บชื่อภาพไว้เพือใช้เขียนลงในตาราง
           // echo $pic = ($name . '.' . $type);
            //เอา path_img ส่งไปให้ model
            $data = array('path_img' => $path_img);

            $this->Student->add_path_img($data, $name); //ส่ง $name เอาไปเป็นตัวอ้างอิง
        }
        //เมื่อ  upload รูปแล้ว ให้ทำการเรียก view get_major_view ขึ้นมาและทำการส่ง $data 
       // $this->load->view('front/get_fac_view',$data);
        $this->img_view($name);  //ส่งค่าไปยัง img_view
    }
    function  img_view($name){
        //ส่งค่าไปยัง view-->>
        $std_id=$name;
        //echo"filename==". $name;
        //ส่งค่าไปให้ model student เพื่อทำการ select
        //$this->Student->get_student($std_id);
        $var['id']=$this->Student->get_student($std_id);
        $this->load->view('front/img_view',$var);
    }
            function add_student() {
        /* function ในการเพิ่มข้อมูลนักศึกษาเข้าระบบ ทำการรับค่ามาจาก view frm_std1 
         * เพิ่มข้อมูล ติดต่อ model student->function add_student
         * insert std_id,std_fname,std_lname,create  to table student
         */
        $data = array(
            'std_id' => $this->input->post('std_id'),
            'std_fname' => $this->input->post('std_fname'),
            'std_lname' => $this->input->post('std_lname'),
            'create' => date('Y-m-d H:i:s')
        );

        if ($this->Student->add_student($data)) {
            
            $this->load->view('front/frm_upload_img', $data);
        }
    }

    function reg_std_fac($data = null) {
        /* function ในการทำการลงทะเบียนในส่วนของคณะของนักศึกษาที่สังกัด
         * 
         */
        // $var['rs'];
        $this->load->view('front/frm_std_fac', $data);
    }

    function get_major() {
        //ส่วนของการเรียกรายชื่อสาขาวิชาขึ้นมาแสดง เพื่อทำการเลือก
        $var['rs'] = $this->Major_Model->get_major();

        $this->load->view();
    }
    function  add_fac(){
        $data=array(
            'fac_id'=>$this->input->post('fac_id'));
        $std_id=$this->input->post('std_id');
        $this->Student->update_fac($data,$std_id);
            echo $data['fac_id'];
    }

}