<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/
/*************************************************************************************/

namespace DealerTeam\Controller;

use Propel\Runtime\Propel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Team\Team;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;

/**
 * Class TeamController
 * @package DealerTeam\Controller
 */
class TeamController extends \Team\Controller\TeamController
{
    /**
     * @inheritDoc
     */
    public function createAction()
    {
        // Check current user authorization
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, Team::getModuleCode(),
                AccessManager::CREATE)
        ) {
            return $response;
        }

        // Create the Creation Form
        $creationForm = $this->getCreationForm($this->getRequest());

        $con = Propel::getConnection();
        $con->beginTransaction();

        try {
            // Check the form against constraints violations
            $form = $this->validateForm($creationForm, "POST");
            // Get the form field values
            $data = $form->getData();

            $createdObject = $this->getService()->createFromArray($data, $this->getCurrentEditionLocale());

            if ($createdObject) {
                $dataLink = [
                    "dealer_id" => $data['dealer_id'],
                    "team_id" => $createdObject->getId()
                ];
                $this->getContainer()->get("dealer_team_service")->createFromArray($dataLink);
            }

            // Substitute _ID_ in the URL with the ID of the created object
            $successUrl = str_replace('_ID_', $this->getObjectId($createdObject), $creationForm->getSuccessUrl());

            $con->commit();

            // Redirect to the success URL
            return $this->generateRedirect($successUrl);

        } catch (FormValidationException $ex) {
            $con->rollBack();
            // Form cannot be validated
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            $con->rollBack();
            // Any other error
            $error_msg = $ex->getMessage();
        }
        if (false !== $error_msg) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("%obj creation", ['%obj' => static::CONTROLLER_ENTITY_NAME]),
                $error_msg,
                $creationForm,
                $ex
            );

            // At this point, the form has error, and should be redisplayed.
            return $this->getListRenderTemplate();
        }

    }


    /**
     * @inheritDoc
     */
    protected function redirectToListTemplate()
    {
        $id = $this->getRequest()->query->get("dealer_id");
        if(null === $id){
            $id = $this->getRequest()->request->get("dealer_id");
        }
        return new RedirectResponse(URL::getInstance()->absoluteUrl("/admin/module/Dealer/dealer/edit#team",["dealer_id" => $id]));
    }


    /**
     * @inheritDoc
     */
    protected function getCreationForm()
    {
        return $this->createForm("dealer_team_team_create");
    }


}