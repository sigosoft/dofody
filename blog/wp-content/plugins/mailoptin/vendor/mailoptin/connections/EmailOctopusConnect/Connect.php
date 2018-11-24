<?php

namespace MailOptin\EmailOctopusConnect;

use MailOptin\Core\Admin\Customizer\OptinForm\Customizer;
use MailOptin\Core\Connections\ConnectionInterface;

class Connect extends AbstractEmailOctopusConnect implements ConnectionInterface
{
    /**
     * @var string key of connection service. its important all connection name ends with "Connect"
     */
    public static $connectionName = 'EmailOctopusConnect';

    public function __construct()
    {
        ConnectSettingsPage::get_instance();

        add_filter('mailoptin_registered_connections', array($this, 'register_connection'));

        add_filter('mo_optin_form_integrations_default', array($this, 'integration_customizer_settings'));
        add_filter('mo_optin_integrations_controls_after', array($this, 'integration_customizer_controls'));

        parent::__construct();
    }

    public static function features_support($connection_service = '')
    {
        return ['optin_campaign'];
    }

    /**
     * Register EmailOctopus Connection.
     *
     * @param array $connections
     *
     * @return array
     */
    public function register_connection($connections)
    {
        $connections[self::$connectionName] = __('EmailOctopus', 'mailoptin');

        return $connections;
    }

    /**
     * Replace placeholder tags with actual EmailOctopus tags.
     *
     * {@inheritdoc}
     */
    public function replace_placeholder_tags($content, $type = 'html')
    {

    }

    /**
     * @param array $settings
     *
     * @return mixed
     */
    public function integration_customizer_settings($settings)
    {
        $settings['EmailOctopusConnectConnect_enable_double_optin'] = apply_filters('mailoptin_customizer_optin_campaign_EmailOctopusConnectConnect_enable_double_optin', false);

        return $settings;
    }

    /**
     * @param array $controls
     * @param \WP_Customize_Manager $wp_customize
     * @param string $option_prefix
     * @param Customizer $customizerClassInstance
     *
     * @return mixed
     */
    public function integration_customizer_controls($controls)
    {
        if (defined('MAILOPTIN_DETACH_LIBSODIUM') === true) {

            $controls[] = [
                'field'       => 'toggle',
                'name'        => 'EmailOctopusConnectConnect_enable_double_optin',
                'label'       => __('Enable Double Optin', 'mailoptin'),
                'description' => __("Double optin requires users to confirm their email address before they are added or subscribed.", 'mailoptin'),
            ];

        } else {

            $content = sprintf(
                __("Upgrade to %sMailOptin Premium%s to enable EmailOctopus %sdouble optin%s.", 'mailoptin'),
                '<a target="_blank" href="https://mailoptin.io/pricing/?utm_source=wp_dashboard&utm_medium=upgrade&utm_campaign=emailoctopus_connection">',
                '</a>',
                '<strong>',
                '</strong>'
            );

            $controls[] = [
                'name'    => 'EmailOctopusConnectConnect_upgrade_notice',
                'field'   => 'custom_content',
                'content' => $content
            ];
        }

        return $controls;
    }

    /**
     * {@inherit_doc}
     *
     * Return array of email list
     *
     * @return mixed
     */
    public function get_email_list()
    {
        try {
            $response = $this->emailoctopus_instance()->get_lists();

            if (isset($response['body'], $response['body']->error)) {
                self::save_optin_error_log($response['body']->error . ': ' . $response['body']->message, 'emailoctopus');
                return null;
            }

            // an array with list id as key and name as value.
            $lists_array = array();

            if ($response['status_code'] >= 200 && $response['status_code'] <= 299) {

                $lists = $response['body']->data;

                if (!empty($lists)) {
                    foreach ($lists as $list) {
                        $lists_array[$list->id] = $list->name;
                    }
                }
            }

            return $lists_array;

        } catch (\Exception $e) {
            self::save_optin_error_log($e->getMessage(), 'emailoctopus');
        }
    }

    /**
     * @param int $email_campaign_id
     * @param int $campaign_log_id
     * @param string $subject
     * @param string $content_html
     * @param string $content_text
     *
     * @throws \Exception
     *
     * @return array
     */
    public function send_newsletter($email_campaign_id, $campaign_log_id, $subject, $content_html, $content_text)
    {

    }

    /**
     * @param string $email
     * @param string $name
     * @param string $list_id ID of email list to add subscriber to
     * @param mixed|null $extras
     *
     * @return mixed
     */
    public function subscribe($email, $name, $list_id, $extras = null)
    {
        return (new Subscription($email, $name, $list_id, $extras))->subscribe();
    }

    /**
     * Singleton poop.
     *
     * @return Connect|null
     */
    public static function get_instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}