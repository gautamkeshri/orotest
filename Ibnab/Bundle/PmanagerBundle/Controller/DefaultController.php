<?php

namespace Ibnab\Bundle\PmanagerBundle\Controller;

use Symfony\Component\Security\Core\Util\ClassUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Ibnab\Bundle\PmanagerBundle\Entity\PDFTemplate;
use Symfony\Component\Routing\RouterInterface;
use Oro\Bundle\AttachmentBundle\Entity\Attachment;
class DefaultController extends Controller
{
    const CONTACT_ENTITY_NAME = 'OroCRM\Bundle\ContactBundle\Entity\Contact';
    const ORDER_ENTITY_NAME = 'OroCRM\Bundle\MagentoBundle\Entity\Order';
     /**
     * @Acl(
     *      id="pmanager_default_index",
     *      type="entity",
     *      class="IbnabPmanagerBundle:PDFTemplate",
     *      permission="EDIT"
     * )
     * @Route("/pmanager/default/index", name="pmanager_default_index")
     * @Template("IbnabPmanagerBundle:Default:index.html.twig")
     */
    public function indexAction()
    {

        $responseData = [
            'saved'  => false
        ];  
        $info = $this->get('request')->get('ibnab_pmanager_exportpdf');
        $importForm = $this->createForm('ibnab_pmanager_exportpdf');
        $attachmentManager = $this->get('oro_attachment.manager');
        $responseData['form'] = $importForm->createView();
        //$importForm = $this->createForm('ibnab_pmanager_exportpdf');
        $responseData['entityClass'] = $info['entityClass'];
        $responseData['entityId'] = $info['entityId'];
        $responseData['process'] = $info['process'] ? $info['process'] : "download" ;
        $pdftemplateEntity = new PDFTemplate();

        if ($templateResult = $this->get('ibnab_pmanager.form.handler.exportpdf')->process())     {
            $entity = $this->getDoctrine()
            ->getRepository($info['entityClass'])
            ->findOneBy(array('id' => $info['entityId']));
             $templateParams = [
                'entity'  => $entity
             ];
             $pdfObj = $this->instancePDF($templateResult);
             $pdfObj->AddPage();
             $outputFormat = 'pdf';
             $resultForPDF = $this->get('oro_email.email_renderer')
            ->renderWithDefaultFilters($templateResult->getContent(),$templateParams);
             $resultForPDF = $templateResult->getCss().$resultForPDF;
              $responseData['resultForPDF'] = $resultForPDF;
            $pdfObj->writeHTML($responseData['resultForPDF'], true, 0, true, 0);
            $pdfObj->lastPage();
    
            //substr($info['entityClass'], strrpos($str, '\\') + 1)
            //$fileName   = $this->getExportHandler()->fileSystemOperator->generateTemporaryFileName($info['entityId'], $outputFormat);
			$fileName = "/var/www/html/norocrm/web/export/download/test1.pdf";
            $pdfObj->Output($fileName, 'F');
            $url     =  $this->get('router')->generate(
                'oro_importexport_export_download',
                ['fileName' => basename($fileName)]
            );
            if($info['process']=='attach')
            {
             $attachment = new Attachment();
             $file = $this->getAttachmentManager()->prepareRemoteFile($fileName);
             $this->getAttachmentManager()->upload($file);
             //$attachment->save()
             $em = $this->getDoctrine()->getManager();
             $em->persist($file);
             $em->flush();
             $attachment->setFile($file);
             $em->persist($attachment);
             $em->flush();             
             //var_dump($attachment);die(); 
             $responseData['attachment_id'] = $attachment->getId();
            }
            
            $responseData['url'] = $url;
            $responseData['saved'] = true;

        }
 
        
        //return $this->update($pdftemplateEntity);
        return $responseData;
    }
    protected function instancePDF($templateResult)
    {
     $orientation = $templateResult->getOrientation() ? $templateResult->getOrientation() : 'P';
     $unit = $templateResult->getUnit() ? $templateResult->getUnit() : 'mm';
     $format = $templateResult->getFormat() ? $templateResult->getFormat() : 'A4';
     $right = $templateResult->getMarginright() ? $templateResult->getMarginright() : '2';
     $top = $templateResult->getMargintop() ? $templateResult->getMargintop() : '2';
     $left = $templateResult->getMarginleft() ? $templateResult->getMarginleft() : '2';
     $bottom = $templateResult->getMarginBottom() ? $templateResult->getMarginBottom() : '2';
     if($templateResult->getAutobreak() == 1)
     {
       $autobreak= true;
     }
     else
     {
      $autobreak= false;
     }
     $pdfObj = $this->get("ibnab_pmanager.tcpdf")->create($orientation,$unit,$format, true, 'UTF-8', false);
     
     $pdfObj->SetCreator($templateResult->getAuteur());
     $pdfObj->SetAuthor($templateResult->getAuteur());
     $pdfObj->SetMargins($left, $top, $right);
     $pdfObj->SetAutoPageBreak($autobreak, $bottom);
     return $pdfObj;
    }    
    protected function getExportHandler()
    {
        return $this->get('oro_importexport.handler.export');
    }
    protected function getAttachmentManager()
    {
        return $this->get('oro_attachment.manager');
    }
     /**    
     * @Acl(
     *      id="pmanager_defaut_create",
     *      type="entity",
     *      class="IbnabPmanagerBundle:PDFTemplate",
     *      permission="EDIT"
     * )
     * @Route("/pmanager/default/create/{id}", name="pmanager_default_create")
     * @Template("IbnabPmanagerBundle:Default:getTemplate.html.twig")
     */
    public function createAction()
    {
        $entityClass = $this->get('request')->get('entityClass');
        $entityId = $this->get('request')->get('id');
        $importForm = $this->createForm('ibnab_pmanager_exportpdf');
        //echo $entityName;die();
        return array(
            'entityClass'  => $entityClass,
            'entityId'  => $entityId,
            'form'       => $importForm->createView()
        );
        
    }
     /**    
     * @Acl(
     *      id="pmanager_defaut_createview",
     *      type="entity",
     *      class="IbnabPmanagerBundle:PDFTemplate",
     *      permission="EDIT"
     * )
     * @Route("/pmanager/default/createview", name="pmanager_default_createview")
     * @Template("IbnabPmanagerBundle:Default:getTemplate.html.twig")
     */
    public function createviewAction()
    {
        $entityClass = $this->get('request')->get('entityClass');
        $entityClass = trim(str_replace("_","\\",$entityClass));
        $entityId = $this->get('request')->get('entityId');
        
        $importForm = $this->createForm('ibnab_pmanager_exportpdf');
        //echo $entityName;die();
        return array(
            'entityClass'  => $entityClass,
            'entityId'  => $entityId,
            'form'       => $importForm->createView()
        );
        
    }
    protected function proccess(PDFTemplate $entity)
    {
        $responseData = [
            'saved'  => false
        ];

        if ($this->get('ibnab_pmanager.form.handler.exportpdf')->process($entity)) {
            $responseData['saved'] = true;
        }
        $responseData['form']       = $this->get('ibnab_pmanager_exportpdf')->createView();

        return $responseData;
    }
    /**
     * @Route("/view/{entityName}", name="pmanager_defaut_view")
     * @Acl(
     *      id="pmanager_defaut_view",
     *      type="entity",
     *      class="IbnabPmanagerBundle:PDFTemplate",
     *      permission="VIEW"
     * )
     * @Template
     */
    public function viewAction($entityName)
    {
        $entity = $this->getDoctrine()
            ->getRepository('IbnabPmanagerBundle:PDFTemplate')
            ->getTemplateByEntityName($entityName);

        return array('entity' => $entity);
    }
	
	/**
     * @Route("/pmanager/default/showdata", name="pmanager_showdata_view")
	 * @Template("IbnabPmanagerBundle:Default:index.html.twig")
     */
    public function showdataAction()
    {
        
        $entityClass = "OroCRM/Bundle/MagentoBundle/Entity/Order";
        $entityId =1;
		
		$pdfClass = "Ibnab/Bundle/PmanagerBundle/Entity/PDFTemplate";
        $pdfId =2;
        
        //$importForm = $this->createForm('ibnab_pmanager_exportpdf');
        
		/*
		return array(
            'entityClass'  => $entityClass,
            'entityId'  => $entityId,
            'form'       => $importForm->createView()
        );
		*/
		$responseData = [
            'saved'  => false
        ];  
        
		$importForm = $this->createForm('ibnab_pmanager_exportpdf');
        $responseData['form'] = $importForm->createView();
        $responseData['entityClass'] = $entityClass;
        $responseData['entityId'] = $entityId;
        $responseData['process'] = "download" ;
        $pdftemplateEntity = new PDFTemplate();
		$pdfentity = $this->getDoctrine()
            ->getRepository($pdfClass)
            ->findOneBy(array('id' => $pdfId));
		//$resultTemplate = $pdfentity->findOneBy(array('id' => 1));
		if ($templateResult = $pdfentity)     {
            $entity = $this->getDoctrine()
            ->getRepository($entityClass)
            ->findOneBy(array('id' => $entityId));
             $templateParams = [
                'entity'  => $entity
             ];
             $pdfObj = $this->instancePDF($templateResult);
             $pdfObj->AddPage();
             $outputFormat = 'pdf';
             $resultForPDF = $this->get('oro_email.email_renderer')
            ->renderWithDefaultFilters($templateResult->getContent(),$templateParams);
             $resultForPDF = $templateResult->getCss().$resultForPDF;
              $responseData['resultForPDF'] = $resultForPDF;
            $pdfObj->writeHTML($responseData['resultForPDF'], true, 0, true, 0);
            $pdfObj->lastPage();
    
            //substr($info['entityClass'], strrpos($str, '\\') + 1)
            $fileName   = $this->getExportHandler()->generateExportFileName($info['entityId'], $outputFormat);
			//var_dump($fileName);die;
            $fileName = "/var/www/html/norocrm/app/cache/test1.pdf";
            $pdfObj->Output($fileName, 'F');
            $url     =  $this->get('router')->generate(
                'oro_importexport_export_download',
                ['fileName' => basename($fileName)]
            );
            $responseData['url'] = $url;
            $responseData['saved'] = true;

        }
		//var_dump($responseData);
		return $responseData;
    }

}
