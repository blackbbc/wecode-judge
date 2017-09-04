<?php
/**
 * Sharif Judge online judge
 * @file Courses.php
 * @author Sweet <505968815@qq.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller
{
    private $edit_course;
    private $edit;

    public function __construct()
    {
        parent::__construct();
		if ( ! $this->session->userdata('logged_in')) // if not logged in
			redirect('login');
		if ( $this->user->level <= 2) // permission denied
			show_404();

        $this->edit_course = array();
        $this->edit = FALSE;
    }

    public function index()
    {
        $data = array(
			'all_assignments' => $this->assignment_model->all_assignments(),
			'courses' => $this->course_model->get_all_courses()
        );

        $this->twig->display('pages/admin/courses.twig', $data);
    }

    public function add()
    {
        if ($this->user->level <= 2)
            show_404();

		$data = array(
            'edit' => $this->edit,
			'all_assignments' => $this->assignment_model->all_assignments(),
		);

        $name = $this->input->post('name');
        if ($name === NULL)
        {
            if ($this->edit)
            {
                $data['edit_course'] = $this->course_model->course_info($this->edit_course);
            }
            $this->twig->display('pages/admin/add_course.twig', $data);
        }
        else
        {
            $registration_code = $this->input->post('registration_code');
            if ($this->edit)
            {
                $this->course_model->update_course($this->edit_course, $name, $registration_code);
            }
            else
            {
                $this->course_model->add_course($name, $registration_code);
            }
            redirect('courses');
        }
    }

    public function delete($course_id = FALSE)
    {
        if ($course_id === FALSE)
            show_404();
        if ($this->user->level <= 2)
            show_404();

        $this->course_model->delete_course($course_id);
        redirect('courses');
    }

    public function edit($course_id)
    {
        if ($this->user->level <= 2)
            show_404();

        $this->edit_course = $course_id;
        $this->edit = TRUE;

        $this->add();
    }

}
