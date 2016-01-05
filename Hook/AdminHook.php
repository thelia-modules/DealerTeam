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

namespace DealerTeam\Hook;

use DealerTeam\DealerTeam;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Translation\Translator;

/**
 * Class AdminHook
 * @package DealerTeam\Hook
 */
class AdminHook extends BaseHook
{
    protected function transQuick($id, $locale, $parameters = [])
    {
        if ($this->translator === null) {
            $this->translator = Translator::getInstance();
        }

        return $this->trans($id, $parameters, DealerTeam::DOMAIN_NAME, $locale);
    }

    public function onDealerEditTab(HookRenderBlockEvent $event){
        $lang = $this->getSession()->getLang();

        $event->add(
            [
                "id" => "dealerteam",
                "class" => "",
                "title" => $this->transQuick("Team", $lang->getLocale()),
                "content" => $this->render("dealerteam.html",$event->getArguments()),
            ]
        );
    }

    public function onDealerEditJs(HookRenderEvent $event)
    {
        $event->add($this->render("js/dealerteam-js.html"));
    }
}