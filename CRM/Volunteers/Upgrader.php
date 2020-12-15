<?php

use CRM_Volunteers_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Volunteers_Upgrader extends CRM_Volunteers_Upgrader_Base
{

    /**
     * Example: Run an external SQL script when the module is installed.
     */
    public function install()
    {
        // install remote event stuff
        $customData = new CRM_Volunteers_CustomData(E::LONG_NAME);
        $customData->syncOptionGroup(E::path('resources/option_group_volunteer_qualifications.json'));
        $customData->syncOptionGroup(E::path('resources/option_group_volunteer_skills.json'));
        //    $customData->syncCustomGroup(E::path('resources/custom_group_remote_registration.json'));
    }


    /**
     * Example: add option value
     *
     * @return TRUE on success
     * @throws Exception
     */
    public function upgrade_0001()
    {
        $this->ctx->log->info('additional qualification');
        $customData = new CRM_Volunteers_CustomData(E::LONG_NAME);
        $customData->syncOptionGroup(E::path('resources/option_group_volunteer_qualifications.json'));
        return true;
    }


}
