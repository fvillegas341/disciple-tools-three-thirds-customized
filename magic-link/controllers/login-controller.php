<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class DT_33_Login_Controller
{
    private $transformers;
    private static $_instance = null;
    public $meta = []; // Allows for instance specific data.

    public $auth = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {
        $this->auth = DT_33_Auth::instance();
        $this->transformers = DT_33_Transformers::instance();
    }

    /**
     * Login a user
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function post_login( WP_REST_Request $request ) {
        $user = wp_authenticate( $request->get_param( 'username' ), $request->get_param( 'password' ) );

        if ( is_wp_error( $user ) ) {
            $error = $user->get_error_message();

            //If the error links to lost password, inject the 3/3rds redirect
            $error = str_replace( '?action=lostpassword', '?action=lostpassword?&redirect_to=/3/3', $error );
            return [
                // Rendered as HTML on the front end, so strip anything but safe markup.
                'error' => wp_kses_post( $error )
            ];
        }

        wp_set_auth_cookie( $user->ID );

        $this->auth->activate();

        return [
            'success' => true
        ];
    }

    /**
     * Create a user
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function post_register( WP_REST_Request $request ) {
        // This endpoint is public. Respect the site's "Anyone can register" setting
        // so strangers can't create accounts when registration is turned off.
        if ( !get_option( 'users_can_register' ) ) {
            return [
                'error' => esc_html__( 'Registration is currently disabled.', 'disciple_tools' )
            ];
        }

        $user = wp_create_user(
            sanitize_user( (string) $request->get_param( 'username' ) ),
            (string) $request->get_param( 'password' ),
            sanitize_email( (string) $request->get_param( 'email' ) )
        );

        if ( is_wp_error( $user ) ) {
            return [
                'error' => wp_kses_post( $user->get_error_message() )
            ];
        }

        wp_set_current_user( $user );

        $groups = $request->get_param( 'groups' );
        if ( is_array( $groups ) ) {
            foreach ( array_slice( $groups, 0, 10 ) as $group_title ) {
                $group_title = sanitize_text_field( (string) $group_title );
                if ( $group_title ) {
                    $group = DT_33_Groups_Repository::instance()->create( [
                        'title' => $group_title,
                    ] );
                }
            }
        }

        return [
            'success' => ! !$user
        ];
    }
}

DT_33_Login_Controller::instance();
