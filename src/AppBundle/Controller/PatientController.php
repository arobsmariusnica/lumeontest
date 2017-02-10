<?php

namespace AppBundle\Controller;

use AppBundle\Services\PatientService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Exception\MissingResourceException;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

class PatientController extends Controller
{

    /**
     * @Method({"POST"})
     * @Route("patient/add")
     */
    public function add(Request $request)
    {
        try{
            // Get translator
            $translator = $this->get('translator');

            // Get Doctor Repository
            $doctorRepository = new \AppBundle\Repository\DoctorRepository($this->getDoctrine());
            // Get Hospital Repository
            $hospitalRepository = new \AppBundle\Repository\HospitalRepository($this->getDoctrine());

            // Check if doctor exists
            if (!($doctor = $doctorRepository->selectById($request->get('doctor_id')))) {
                throw new MissingResourceException($translator->trans('doctor.not_found'));
            }
            // Check if hospital exists
            if (!($hospital = $hospitalRepository->selectById($request->get('hospital_id')))) {
                throw new MissingResourceException($translator->trans('hospital.not_found'));
            }

            //save patient against doctor and hospital
            $patientService = new PatientService($this->getDoctrine()->getManager());
            $patientService->save(
                $doctor,
                $hospital,
                array(
                    "hospital_id" => $request->get('hospital_id'),
                    "doctor_id" => $request->get('doctor_id'),
                    "name" => $request->get('name'),
                    "gender" => $request->get('gender'),
                    "dob" => $request->get('dob')
                )
            );

            // Get the list of pacients
            $patients = $doctor->getPatients();

            // Return the list of patients along with the original hospital and a message showing success
            return $this->jsonResponse(
                array(
                    'patient' => $this->serialize($patients),
                    'doctor' => $doctor->getName(),
                    'hospital' => $hospital->getName(),
                )
            );

        } catch (MissingResourceException $e) {
            return $this->jsonResponse(
                array(
                    'msg' => $e->getMessage()
                )
            );
        }
    }

    /**
     * @param $response
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonResponse($response)
    {
        return new \Symfony\Component\HttpFoundation\JsonResponse(
            $response
        );
    }

    /**
     * @param $response
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function serialize($array)
    {
        $result = array();
        foreach($array as $obj){
            $result[] = ['id' => $obj->getId(), 'name' => $obj->getName()];
        }

        return $result;
    }
}
