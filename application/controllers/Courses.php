<?php
/**
 * Sharif Judge online judge
 * @file Courses.php
 * @author Sweet <505968815@qq.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		if ( ! $this->session->userdata('logged_in')) // if not logged in
			redirect('login');
		if ( $this->user->level <= 2) // permission denied
			show_404();
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
			'all_assignments' => $this->assignment_model->all_assignments(),
		);

        $name = $this->input->post('name');
        if ($name === NULL)
        {
            $this->twig->display('pages/admin/add_course.twig', $data);
        }
        else
        {
            $registration_code = $this->input->post('registration_code');
            $this->course_model->add_course($name, $registration_code);
            redirect('courses');
        }
    }

    public function delete($course_id = FALSE)
    {
        if ($assignment_id === FALSE)
            show_404();
        if ($this->user->level <= 2)
            show_404();

        if ($this->input->post('delete') === 'delete')
        {
            $this->course_model->delete_course($course_id);
            redirect('courses');
        }

    }

}
