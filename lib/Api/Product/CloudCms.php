<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2015 Spring Signage Ltd
 * (CloudCms.php)
 */


namespace SpringSignage\Api\Product;


class CloudCms implements Product
{
    public $productId = 2;
    public $accountName;
    public $displays;
    public $isDemo;
    public $upgradeId;
    public $monthlyBilling;
    public $domainId;
    public $themeId;
    public $cmsVersionId;
    public $regionId;

    /**
     * Set for a New Account
     * @param string $accountName
     * @param int $displays
     * @param bool $isDemo
     * @param int $regionId
     * @param int $monthlyBilling
     * @param int[Optional] $cmsVersionId If not provided this will be the latest version
     * @param int[Optional] $domainId If not provided this will be xibo.co.uk
     * @param int[Optional] $themeId If not provided this will be the spring signage xibo theme
     */
    public function setNewInstance($accountName, $displays, $isDemo, $regionId, $monthlyBilling = 0, $cmsVersionId = null, $domainId = null, $themeId = null)
    {
        $this->accountName = $accountName;
        $this->displays = $displays;
        $this->isDemo = $isDemo;
        $this->regionId = $regionId;
        $this->monthlyBilling = $monthlyBilling;
        $this->cmsVersionId = $cmsVersionId;
        $this->domainId = $domainId;
        $this->themeId = $themeId;
    }

    /**
     * Add displays to an existing account
     * @param int $upgradeId
     * @param int $displays
     */
    public function setChangeExistingInstance($upgradeId, $displays)
    {
        $this->upgradeId = $upgradeId;
        $this->displays = $displays;
    }

    public function productDetails()
    {
        // Common
        $details = [
            'displays' => $this->displays
        ];

        if ($this->upgradeId == 0) {
            // New account
            $details['account_name'] = $this->accountName;
            $details['monthly_billing'] = $this->monthlyBilling;
            $details['is_demo'] = ($this->isDemo) ? 1 : 0;
            $details['region_id'] = $this->regionId;
            $details['domain_id'] = $this->domainId;
            $details['theme_id'] = $this->themeId;
            $details['cms_version_id'] = $this->cmsVersionId;
        }
        else {
            // Existing account
            $details['upgradeId'] = $this->upgradeId;
        }

        return $details;
    }
}