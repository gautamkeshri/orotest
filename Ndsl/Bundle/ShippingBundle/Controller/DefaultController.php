<?php

namespace Ndsl\Bundle\ShippingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ndsl\Bundle\ShippingBundle\Entity\Delhivery;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    private $warehouse;
    private $mode;
    private $apiurl;
    private $token;

    /**
     * @Route("/index", name="ndsl_index")
     * @Template
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/view/{id}", name="ndsl_index_view", requirements={"id"="\d+"})
     * @Template
     * @param Delhivery   $entity
     * @return array
     */
    public function viewAction(Delhivery $entity) {
		//echo "<pre>";
		//var_dump($entity);die;
        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route("/create", name="ndsl_shipping_create")
     * @Template("NdslShippingBundle:Default:update.html.twig")
     */
    public function createAction() {
        $formAction = $this->get('oro_entity.routing_helper')
                ->generateUrlByRequest('ndsl_shipping_create', $this->getRequest());
        $entity = new Delhivery();
        return $this->update($entity, $formAction);
    }

    /**
     * @Route("/update/{id}", name="ndsl_shipping_update", requirements={"id"="\d+"})
     * @Template
     */
    public function updateAction(Delhivery $entity) {
        $formAction = $this->get('router')->generate('ndsl_shipping_update', ['id' => $entity->getId()]);

        return $this->update($entity, $formAction);
    }

    /**
     * @param Delhivery   $entity
     * @param string $formAction
     *
     * @return array
     */
    protected function update(Delhivery $entity, $formAction) {
        $saved = false;

        if ($this->get('ndsl_shipping.form.handler')->process($entity)) {
            if (!$this->getRequest()->get('_widgetContainer')) {
                $this->get('session')->getFlashBag()->add(
                        'success', $this->get('translator')->trans('ndsl_shipping.simple_crud.controller.saved.message')
                );

                return $this->get('oro_ui.router')->redirectAfterSave(
                                ['route' => 'ndsl_shipping_update', 'parameters' => ['id' => $entity->getId()]], ['route' => 'ndsl_index'], $entity
                );
            }
            $saved = true;
        }

        return array(
            'entity' => $entity,
            'saved' => $saved,
            'form' => $this->get('ndsl_shipping.form.handler')->getForm()->createView(),
            'formAction' => $formAction
        );
    }

    /**
     * @Route("/delete/{id}", name="ndsl_shipping_delete", requirements={"id"="\d+"})
     * @Template
     */
    public function deleteAction($id) {
        $manager = $this->getDoctrine()->getManager();
        $entity = $manager->find('Ndsl\Bundle\ShippingBundle\Entity\Delhivery', $id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add(
                    'error', $this->get('translator')->trans('ndsl_shipping.simple_crud.controller.notfound.message')
            );
            return $this->redirect($this->generateUrl('ndsl_index'));
        }

        $manager->remove($entity);
        $manager->flush();

        $this->get('session')->getFlashBag()->add(
                'success', $this->get('translator')->trans('ndsl_shipping.simple_crud.controller.deleted.message')
        );

        return $this->redirect($this->generateUrl('ndsl_index'));
    }
	
	/**
     * @Route("/generatepdf/{id}", name="ndsl_generate_pdf", requirements={"id"="\d+"})
     * @Template
     */
    public function generatepdfAction($id) {
		$pdfClass = "Ndsl/Bundle/ShippingBundle/Entity/Delhivery";
        $pdfId =3;
		$pdfentity = $this->getDoctrine()
            ->getRepository($pdfClass)
            ->findOneBy(array('id' => $pdfId));
		return [
            'entity' => $pdfentity,
        ];
    }

}
