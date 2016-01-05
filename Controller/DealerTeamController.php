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

use DealerTeam\DealerTeam;
use DealerTeam\Service\DealerTeamService;
use Propel\Runtime\Propel;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\JsonResponse;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Log\Tlog;

/**
 * Class DealerTeamController
 * @package DealerTeam\Controller
 */
class DealerTeamController extends BaseAdminController
{
    /** @var DealerTeamService $service */
    protected $service;

    public function updateOrCreateLinkAction($id)
    {
        // Check current user authorization
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, DealerTeam::getModuleCode(),
                AccessManager::CREATE)
        ) {
            return $response;
        }

        $retour = [];
        $code = 200;

        $con = Propel::getConnection();
        $con->beginTransaction();

        try {
            $data = ['id' => $id];
            $tempOption = $this->getRequest()->request->get("option_id");
            $dafyDealer=[];
            foreach($tempOption as $option){
                $data["dealer_option_id"] = $option;
                $temp = $this->getService()->createFromArray($data);
                if($temp){
                    $dafyDealer[] = $temp->toArray();
                }
            }


            $con->commit();

            $retour["data"] = $dafyDealer;
        } catch (\Exception $e) {
            $con->rollBack();
            // Any other error
            Tlog::getInstance()->addError($e->getMessage());
            $code = $e->getCode();
            if ($code == 0) {
                $code = 500;
            }
            $retour["message"] = $e->getMessage();
        }

        return JsonResponse::create($retour, $code);
    }


    protected function getService()
    {
        if (!$this->service) {
            $this->service = $this->container->get("dealer_team_service");
        }

        return $this->service;
    }
}