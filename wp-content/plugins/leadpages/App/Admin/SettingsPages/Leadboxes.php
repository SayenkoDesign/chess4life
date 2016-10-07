<?php


namespace LeadpagesWP\Admin\SettingsPages;

use LeadpagesWP\Helpers\LeadboxDisplay;
use TheLoop\Contracts\SettingsPage;
use TheLoop\ServiceContainer\ServiceContainerTrait;

class Leadboxes implements SettingsPage
{

    use ServiceContainerTrait;
    use LeadboxDisplay;

    public static function getName(){
        return get_called_class();
    }

    public function definePage() {
        global $leadpagesConfig;

        if(isset($_GET['page']) && $_GET['page'] == 'Leadboxes') {
            add_action('admin_enqueue_scripts', array($this, 'leadboxScripts'));
        }

        add_menu_page('leadboxes', 'Leadboxes', 'manage_options', 'Leadboxes', array($this, 'displayCallback'), $leadpagesConfig['admin_images'].'/leadboxes_sm.png' );
    }

    public function displayCallback(){
        ?>
        <div id="leadboxesLoading">
            <div class="ui-loading">
                <div class="ui-loading__dots ui-loading__dots--1"></div>
                <div class="ui-loading__dots ui-loading__dots--2"></div>
                <div class="ui-loading__dots ui-loading__dots--3"></div>
            </div>
        </div>
        <div id="leadboxesForm" style="display:none">
            <form action="admin-post.php" method="post">

                <h2>Configure Leadboxes&reg</h2>
                <p>Here you can setup timed and exit Leadboxes&reg;. If you want to place a Leadbox&trade; via link, button, or image to any page, you need to copy and paste the HTML code you'll find in the Leadbox&trade; publish interface inside the Leadpages&trade; application.</p>
                <div id="leadbox-options">
                    <div id="timed-leadboxes">
                        <h2>Timed Leadbox&trade; Configuration</h2>
                        <p>All your LeadBoxes&reg; with Timed configuration are listed below. Go to our <a href="https://my.leadpages.net" target="_blank"> application </a>   to save or edit Timed settings for your LeadBoxes&reg;</p>
                        <div class="timedLeadboxes">
                            <label for="timed-leadboxes"><h3 style="display:inline;">Timed Lead Boxes:</h3></label>
                            <div class="timeLeadBoxes"></div>
                            <div class="postTypesForTimedLeadbox"></div>
                            <div id="selectedLeadboxSettings"></div>
                        </div>
                    </div>
                    <hr />
                    <div id="timed-leadboxes">
                        <h2>Exit Leadbox&trade; Configuration</h2>
                        <p>All your Leadboxes&reg; are listed below. Any LeadBoxes&reg; without Exit configuration will default to display every time a user visits your page. Go to our <a href="https://my.leadpages.net" target="_blank"> application </a> to use your own settings.</p>
                        <div class="exitLeadboxes">
                            <label for="timed-leadboxes"><h3 style="display:inline;">Exit Lead Boxes:</h3></label>
                            <div class="exitLeadBoxes"></div>
                            <div class="postTypesForExitLeadbox"></div>
                            <div id="selectedExitLeadboxSettings"></div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="action" value="save_leadbox_options" />
                <?php wp_nonce_field( 'save_leadbox_options' ); ?>
                <input type="submit" value="Save Global Leadboxes" class="leadboxButton">
            </form>
        </div>
        <?php

    }

    public function registerPage(){
        add_action( 'admin_menu', array($this, 'definePage') );

    }


    public function leadboxScripts(){
        global $leadpagesConfig;
        global $leadpagesApp;

        $apiResponse = $leadpagesApp['leadboxesApi']->getAllLeadboxes();
        $allLeadboxes = json_decode($apiResponse['response'], true);
        $leadboxes['_items'] = array_filter($allLeadboxes['_items'], array($this, 'filterLeadpageGeneratedLeadboxes'));

        wp_enqueue_script('Leadboxes', $leadpagesConfig['admin_assets'] . '/js/Leadboxes.js', array('jquery'));
        wp_localize_script('Leadboxes', 'leadboxes_object', array(
          'ajax_url'  => admin_url('admin-ajax.php'),
          'timedLeadboxes' => $this->timedDropDown($leadboxes),
          'postTypesForTimedLeadboxes' => $this->postTypesForTimedLeadboxes(),
          'postTypesForExitLeadboxes' => $this->postTypesForExitLeadboxes(),
          'exitLeadboxes'  => $this->exitDropDown($leadboxes),
        ));
    }

    /**
     * Loop over leadboxes using array filter and only return leadboxes
     * that actually have embed code
     * @param $leadboxes
     * @param $body
     */
    public function filterLeadpageGeneratedLeadboxes($leadbox)
    {
        //if embed is not set it is not published so it must be removed
        if (!empty($leadbox['publish_settings']['embed'])) {
           return $leadbox;
        }
    }


}