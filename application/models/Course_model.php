<?php
/**
 * Sharif Judge online judge
 * @file Course_model.php
 * @author Sweet <505968815@qq.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function add_course($name, $registration_code)
    {
        $this->db->trans_start();

        $course = array(
            'name' => $name,
            'registration_code' => $registration_code
        );

        $this->db->insert('courses', $course);


        $this->db->trans_complete();

        return TRUE;
    }

    public function get_course($course_id)
    {
        $query = $this->db->get_where('courses', array('id'=>$course_id));
        if ($query->num_rows() != 1)
            return FALSE;
        return $query->row();
    }

    public function course_info($course_id)
    {
        $query = $this->db->get_where('courses', array('id'=>$course_id));
        if ($query->num_rows() != 1)
            return array(
                'id' => 0,
                'name' => '',
                'registration_code' => ''
            );
        return $query->row_array();
    }

    public function get_all_courses()
    {
        return $this->db->order_by('id')->get('courses')->result_array();
    }

    public function delete_course($course_id)
    {
        $this->db->trans_start();

        $this->db->delete('courses', array('id'=>$course_id));

        $this->db->trans_complete();

        return TRUE;
    }

    public function update_course($course_id, $name, $registration_code)
    {
        $this->db->trans_start();

        $course = array(
            'name' => $name,
            'registration_code' => $registration_code
        );

        $this->db->where('id', $course_id)->update('courses', $course);

        $this->db->trans_complete();

        return TRUE;
    }

}
