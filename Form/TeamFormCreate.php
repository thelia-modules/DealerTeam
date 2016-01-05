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

namespace DealerTeam\Form;

use Team\Form\TeamCreateForm;

/**
 * Class TeamFormCreate
 * @package DealerTeam\Form
 */
class TeamFormCreate extends TeamCreateForm
{

    /**
     * @inheritDoc
     */
    protected function buildForm()
    {
        parent::buildForm();
        $this->formBuilder->add("dealer_id","integer");
    }

    public function getName()
    {
        return "dealer_team_team_create";
    }


}