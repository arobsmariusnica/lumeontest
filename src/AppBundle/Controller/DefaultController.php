<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Intl\Exception\MissingResourceException;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

class DefaultController extends Controller
{
    /**
     * Get the list of patients based on hotelId
     *
     * @Route("hospital_patients/{hospitalId}", name="hospitalId", requirements={"hospitalId": "\d+"})
     */
    public function hospitalPacientsAction($hospitalId)
    {
        try{
            // Get translator
            $translator = $this->get('translator');

            // Get Hospital Repository
            $hospitalRepository = new \AppBundle\Repository\HospitalRepository($this->getDoctrine());

            // Check if hotel exists
            if (!($hospital = $hospitalRepository->selectById($hospitalId))) {
                throw new MissingResourceException($translator->trans('hospital.not_found'));
            }

            // Get the list of pacients
            $patients = $hospital->getPacients();//$patientRepository->selectByHospital($hospital);

            // Return the list of patients along with the original hospital and a message showing success
            return $this->jsonResponse(
                array(
                    'patients' => $this->serialize($patients),
                    'hospital' => $hospital->getName(),
                    'msg' => $translator->trans('list.patients').$hospital->getName()
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
     * Get the list of patients based on hotelId
     *
     * @Route("doctor_patients/{doctorId}", name="doctorId", requirements={"doctorId": "\d+"})
     */
    public function doctorPacientsAction($doctorId)
    {
        try{
            // Get translator
            $translator = $this->get('translator');

            $doctorRepository = new \AppBundle\Repository\DoctorRepository($this->getDoctrine());

            // Check if doctor exists
            if (!($doctor = $doctorRepository->selectById($doctorId))) {
                throw new MissingResourceException($translator->trans('doctor.not_found'));
            }

            // Get the list of pacients
            $patients = $doctor->getPacients();

            // Return a list of patients along with the original hospital and a message showing success
            return $this->jsonResponse(
                array(
                    'patients' => $this->serialize($patients),
                    'doctor' => $doctor->getName(),
                    'msg' => $translator->trans('list.patients').$doctor->getName()
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
