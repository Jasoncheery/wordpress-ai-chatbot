<?php
/**
 * Plugin Name: Simple LLM Chatbot with Analytics
 * Description: A chatbot using OpenRouter LLM with Knowledge Base management and Analytics dashboard.
 * Version: 1.0.0
 * Author: AI Infinity Team
 * Author URI: https://ainfinity.shop
 * Text Domain: simple-llm-chatbot
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Define plugin constants
define('SLC_VERSION', '1.0.0');
define('SLC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SLC_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * CREATE DATABASE TABLE ON ACTIVATION
 * Performance: Using proper indexes for session_id and created_at for analytics queries
 */
register_activation_hook(__FILE__, 'slc_create_db_table');
function slc_create_db_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'simple_llm_logs';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        session_id varchar(100) NOT NULL,
        user_message text NOT NULL,
        bot_response text NOT NULL,
        is_helpful tinyint(1) DEFAULT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY session_id (session_id),
        KEY created_at (created_at),
        KEY is_helpful (is_helpful)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/**
 * ADMIN MENU PAGES
 */
add_action('admin_menu', 'slc_add_admin_menu');
function slc_add_admin_menu() {
    add_options_page(
        'LLM Chatbot Settings',
        'LLM Chatbot',
        'manage_options',
        'simple-llm-chatbot',
        'slc_settings_page'
    );
    
    add_menu_page(
        'Chatbot Analytics',
        'Chat Analytics',
        'manage_options',
        'simple-llm-analytics',
        'slc_analytics_page',
        'dashicons-chart-bar',
        6
    );
}

/**
 * SETTINGS PAGE
 */
function slc_settings_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // Add nonce for security
    if (isset($_POST['slc_settings_nonce']) && wp_verify_nonce($_POST['slc_settings_nonce'], 'slc_save_settings')) {
        update_option('slc_api_key', sanitize_text_field($_POST['slc_api_key']));
        update_option('slc_system_prompt', sanitize_textarea_field($_POST['slc_system_prompt']));
        update_option('slc_knowledge_base', sanitize_textarea_field($_POST['slc_knowledge_base']));
        update_option('slc_model', sanitize_text_field($_POST['slc_model']));
        echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
    }

    $api_key = get_option('slc_api_key', '');
    $system_prompt = get_option('slc_system_prompt', 'You are a helpful customer support assistant.');
    $knowledge_base = get_option('slc_knowledge_base', '');
    $model = get_option('slc_model', 'openai/gpt-3.5-turbo');
    ?>
    <div class="wrap">
        <h1>LLM Chatbot Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('slc_save_settings', 'slc_settings_nonce'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">OpenRouter API Key</th>
                    <td>
                        <input type="password" name="slc_api_key" value="<?php echo esc_attr($api_key); ?>" style="width: 100%; max-width: 600px;" />
                        <p class="description">Get your API key from <a href="https://openrouter.ai/keys" target="_blank">OpenRouter</a></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Model</th>
                    <td>
                        <input type="text" name="slc_model" value="<?php echo esc_attr($model); ?>" style="width: 100%; max-width: 600px;" />
                        <p class="description">Default: openai/gpt-3.5-turbo. See <a href="https://openrouter.ai/models" target="_blank">available models</a></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">System Prompt (Persona)</th>
                    <td>
                        <textarea name="slc_system_prompt" rows="5" style="width: 100%; max-width: 600px;"><?php echo esc_textarea($system_prompt); ?></textarea>
                        <p class="description">Define the chatbot's personality and behavior.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Knowledge Base (Context)</th>
                    <td>
                        <textarea name="slc_knowledge_base" rows="15" style="width: 100%; max-width: 600px;"><?php echo esc_textarea($knowledge_base); ?></textarea>
                        <p class="description">Paste your FAQs, business info, or documentation here. This will be fed to the AI as context.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * ANALYTICS PAGE
 * Performance: Using indexed columns and LIMIT for queries
 */
function slc_analytics_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'simple_llm_logs';
    
    // Check if table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        echo '<div class="wrap"><h1>Chatbot Analytics</h1><p>No data available yet. The database table will be created automatically.</p></div>';
        return;
    }
    
    // Stats - Using indexed columns for performance
    $total_conversations = $wpdb->get_var("SELECT COUNT(DISTINCT session_id) FROM $table_name");
    $total_messages = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $helpful_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE is_helpful = 1");
    $total_rated = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE is_helpful IS NOT NULL");
    
    $success_rate = ($total_rated > 0) ? round(($helpful_count / $total_rated) * 100, 1) : 0;
    
    // Recent logs - LIMIT to prevent unbounded queries
    $recent_logs = $wpdb->get_results(
        "SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 50"
    );
    
    // Frequently asked questions - Using GROUP BY with LIMIT
    $top_questions = $wpdb->get_results(
        "SELECT user_message, COUNT(*) as count 
        FROM $table_name 
        GROUP BY user_message 
        ORDER BY count DESC 
        LIMIT 10"
    );
    ?>
    <div class="wrap">
        <h1>Chatbot Analytics</h1>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #666; font-size: 14px;">Total Conversations</h3>
                <p style="font-size: 32px; font-weight: bold; margin: 0; color: #0073aa;"><?php echo number_format($total_conversations); ?></p>
            </div>
            <div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #666; font-size: 14px;">Total Messages</h3>
                <p style="font-size: 32px; font-weight: bold; margin: 0; color: #0073aa;"><?php echo number_format($total_messages); ?></p>
            </div>
            <div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #666; font-size: 14px;">Success Rate</h3>
                <p style="font-size: 32px; font-weight: bold; margin: 0; color: #28a745;"><?php echo $success_rate; ?>%</p>
            </div>
        </div>

        <h2>Top 10 Frequently Asked Questions</h2>
        <table class="wp-list-table widefat fixed striped" style="margin-bottom: 30px;">
            <thead>
                <tr>
                    <th style="width: 80%;">Question</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($top_questions) : foreach ($top_questions as $q) : ?>
                <tr>
                    <td><?php echo esc_html($q->user_message); ?></td>
                    <td><?php echo number_format($q->count); ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="2">No data yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Recent Interactions (Last 50)</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 15%;">Time</th>
                    <th style="width: 30%;">User Message</th>
                    <th style="width: 40%;">Bot Response</th>
                    <th style="width: 15%;">Helpful?</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($recent_logs) : foreach ($recent_logs as $log) : ?>
                <tr>
                    <td><?php echo esc_html($log->created_at); ?></td>
                    <td><?php echo esc_html($log->user_message); ?></td>
                    <td><?php echo esc_html(wp_trim_words($log->bot_response, 20, '...')); ?></td>
                    <td>
                        <?php 
                        if ($log->is_helpful === '1') echo '<span style="color:green;">👍 Yes</span>';
                        elseif ($log->is_helpful === '0') echo '<span style="color:red;">👎 No</span>';
                        else echo '<span style="color:#999;">-</span>';
                        ?>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="4">No interactions yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

/**
 * REGISTER SETTINGS
 */
add_action('admin_init', 'slc_register_settings');
function slc_register_settings() {
    register_setting('slc_options_group', 'slc_api_key', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('slc_options_group', 'slc_system_prompt', array('sanitize_callback' => 'sanitize_textarea_field'));
    register_setting('slc_options_group', 'slc_knowledge_base', array('sanitize_callback' => 'sanitize_textarea_field'));
    register_setting('slc_options_group', 'slc_model', array('sanitize_callback' => 'sanitize_text_field'));
}

/**
 * REST API ENDPOINTS
 * Performance: Using REST API instead of admin-ajax.php for better performance
 */
add_action('rest_api_init', function () {
    register_rest_route('simple-llm/v1', '/chat', array(
        'methods' => 'POST',
        'callback' => 'slc_handle_chat',
        'permission_callback' => '__return_true',
        'args' => array(
            'message' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param) && !empty(trim($param));
                }
            ),
            'session_id' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param);
                }
            )
        )
    ));
    
    register_rest_route('simple-llm/v1', '/feedback', array(
        'methods' => 'POST',
        'callback' => 'slc_handle_feedback',
        'permission_callback' => '__return_true',
        'args' => array(
            'log_id' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return is_numeric($param);
                }
            ),
            'is_helpful' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return is_bool($param);
                }
            )
        )
    ));
});

/**
 * HANDLE CHAT REQUEST
 * Performance: Using wp_remote_post with timeout, proper error handling
 */
function slc_handle_chat($request) {
    global $wpdb;
    
    $params = $request->get_json_params();
    $user_message = sanitize_text_field($params['message']);
    $session_id = sanitize_text_field($params['session_id']);
    
    // Get settings
    $api_key = get_option('slc_api_key');
    $system_prompt = get_option('slc_system_prompt', 'You are a helpful customer support assistant.');
    $knowledge_base = get_option('slc_knowledge_base', '');
    $model = get_option('slc_model', 'openai/gpt-3.5-turbo');

    if (empty($api_key)) {
        return new WP_Error('no_api_key', 'API Key not configured. Please configure in Settings > LLM Chatbot.', array('status' => 500));
    }

    // Construct the full system message with knowledge base
    $full_system_message = $system_prompt;
    if (!empty($knowledge_base)) {
        $full_system_message .= "\n\n=== KNOWLEDGE BASE ===\n" . $knowledge_base;
    }

    // Prepare API request
    $body = array(
        'model' => $model,
        'messages' => array(
            array('role' => 'system', 'content' => $full_system_message),
            array('role' => 'user', 'content' => $user_message)
        )
    );

    // Make API request with proper timeout
    $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json',
            'HTTP-Referer' => get_site_url(),
            'X-Title' => get_bloginfo('name')
        ),
        'body' => wp_json_encode($body),
        'timeout' => 30, // Performance: Set reasonable timeout
        'sslverify' => true
    ));

    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Failed to connect to OpenRouter: ' . $response->get_error_message(), array('status' => 500));
    }

    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        $error_body = wp_remote_retrieve_body($response);
        return new WP_Error('api_error', 'OpenRouter API error (HTTP ' . $response_code . '): ' . $error_body, array('status' => $response_code));
    }

    $body_content = json_decode(wp_remote_retrieve_body($response), true);
    $bot_reply = $body_content['choices'][0]['message']['content'] ?? 'Sorry, I could not process your request.';

    // Log to database - Performance: Using prepared statement
    $table_name = $wpdb->prefix . 'simple_llm_logs';
    $wpdb->insert(
        $table_name,
        array(
            'session_id' => $session_id,
            'user_message' => $user_message,
            'bot_response' => $bot_reply,
            'created_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s')
    );
    
    $log_id = $wpdb->insert_id;

    return rest_ensure_response(array(
        'reply' => $bot_reply,
        'log_id' => $log_id
    ));
}

/**
 * HANDLE FEEDBACK
 * Performance: Simple UPDATE with WHERE clause
 */
function slc_handle_feedback($request) {
    global $wpdb;
    
    $params = $request->get_json_params();
    $log_id = intval($params['log_id']);
    $is_helpful = $params['is_helpful'] ? 1 : 0;
    
    $table_name = $wpdb->prefix . 'simple_llm_logs';
    
    // Performance: Using prepared statement
    $wpdb->update(
        $table_name,
        array('is_helpful' => $is_helpful),
        array('id' => $log_id),
        array('%d'),
        array('%d')
    );
    
    return rest_ensure_response(array('success' => true));
}

/**
 * ENQUEUE FRONTEND ASSETS
 * Performance: Only load on frontend, not admin; using wp_enqueue_scripts
 */
add_action('wp_enqueue_scripts', 'slc_enqueue_frontend_assets');
function slc_enqueue_frontend_assets() {
    // Only load if not in admin
    if (is_admin()) {
        return;
    }
    
    // Inline styles and scripts for simplicity (no extra HTTP requests)
    add_action('wp_footer', 'slc_render_chat_widget', 999);
}

/**
 * RENDER CHAT WIDGET
 * Performance: Inline CSS/JS to avoid extra HTTP requests
 */
function slc_render_chat_widget() {
    // Don't show on admin pages
    if (is_admin()) {
        return;
    }
    ?>
    <style>
        #slc-chat-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        }
        #slc-chat-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-size: 28px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        #slc-chat-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }
        #slc-chat-window {
            display: none;
            width: 380px;
            height: 550px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            flex-direction: column;
            position: absolute;
            bottom: 80px;
            right: 0;
            overflow: hidden;
        }
        #slc-chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 20px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
        }
        #slc-chat-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: background 0.2s;
        }
        #slc-chat-close:hover {
            background: rgba(255,255,255,0.2);
        }
        #slc-chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        #slc-chat-input-area {
            padding: 15px;
            border-top: 1px solid #eee;
            display: flex;
            gap: 10px;
            background: white;
        }
        #slc-chat-input {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        #slc-chat-input:focus {
            border-color: #667eea;
        }
        #slc-chat-send {
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: opacity 0.2s;
        }
        #slc-chat-send:hover {
            opacity: 0.9;
        }
        #slc-chat-send:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .slc-message {
            padding: 10px 14px;
            border-radius: 12px;
            max-width: 75%;
            word-wrap: break-word;
            line-height: 1.5;
            font-size: 14px;
        }
        .slc-user {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            align-self: flex-end;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }
        .slc-bot {
            background: white;
            color: #333;
            align-self: flex-start;
            border: 1px solid #e0e0e0;
            border-bottom-left-radius: 4px;
        }
        .slc-feedback {
            font-size: 11px;
            margin-top: 6px;
            color: #666;
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .slc-feedback button {
            background: none;
            border: 1px solid #ddd;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.2s;
        }
        .slc-feedback button:hover {
            background: #f0f0f0;
            border-color: #999;
        }
        .slc-feedback button.selected {
            background: #667eea;
            border-color: #667eea;
            color: white;
        }
        .slc-typing {
            opacity: 0.6;
            font-style: italic;
        }
        
        /* Mobile responsive */
        @media (max-width: 480px) {
            #slc-chat-window {
                width: calc(100vw - 40px);
                height: calc(100vh - 100px);
                right: 20px;
                bottom: 80px;
            }
        }
    </style>

    <div id="slc-chat-widget">
        <div id="slc-chat-window">
            <div id="slc-chat-header">
                <span>💬 Chat Support</span>
                <button id="slc-chat-close" onclick="slcToggleChat()" aria-label="Close chat">✕</button>
            </div>
            <div id="slc-chat-messages"></div>
            <div id="slc-chat-input-area">
                <input type="text" id="slc-chat-input" placeholder="Type your message..." onkeypress="slcHandleEnter(event)" />
                <button id="slc-chat-send" onclick="slcSendMessage()">Send</button>
            </div>
        </div>
        <button id="slc-chat-button" onclick="slcToggleChat()" aria-label="Open chat">💬</button>
    </div>

    <script>
        // Generate unique session ID
        let slcSessionId = 'sess_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
        let slcIsProcessing = false;
        
        function slcToggleChat() {
            const win = document.getElementById('slc-chat-window');
            const isVisible = win.style.display === 'flex';
            win.style.display = isVisible ? 'none' : 'flex';
            
            if (!isVisible) {
                document.getElementById('slc-chat-input').focus();
                
                // Welcome message on first open
                const messages = document.getElementById('slc-chat-messages');
                if (messages.children.length === 0) {
                    slcAddMessage('Hello! How can I help you today?', 'bot');
                }
            }
        }

        function slcHandleEnter(e) {
            if (e.key === 'Enter' && !slcIsProcessing) {
                slcSendMessage();
            }
        }

        async function slcSendMessage() {
            if (slcIsProcessing) return;
            
            const input = document.getElementById('slc-chat-input');
            const sendBtn = document.getElementById('slc-chat-send');
            const msg = input.value.trim();
            
            if (!msg) return;

            slcIsProcessing = true;
            sendBtn.disabled = true;
            
            slcAddMessage(msg, 'user');
            input.value = '';
            
            // Show typing indicator
            const loadingId = slcAddMessage('Typing...', 'bot', true);

            try {
                const res = await fetch('<?php echo esc_url(rest_url('simple-llm/v1/chat')); ?>', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                    },
                    body: JSON.stringify({ 
                        message: msg, 
                        session_id: slcSessionId 
                    })
                });
                
                const data = await res.json();
                
                // Remove typing indicator
                const loadingElem = document.getElementById(loadingId);
                if (loadingElem) loadingElem.remove();
                
                if (data.reply) {
                    const botMsgId = slcAddMessage(data.reply, 'bot');
                    if (data.log_id) {
                        slcAddFeedback(botMsgId, data.log_id);
                    }
                } else if (data.message) {
                    slcAddMessage('Error: ' + data.message, 'bot');
                } else {
                    slcAddMessage('Sorry, something went wrong. Please try again.', 'bot');
                }
                
            } catch (err) {
                console.error('Chat error:', err);
                const loadingElem = document.getElementById(loadingId);
                if (loadingElem) loadingElem.remove();
                slcAddMessage('Connection error. Please check your internet and try again.', 'bot');
            } finally {
                slcIsProcessing = false;
                sendBtn.disabled = false;
                input.focus();
            }
        }

        function slcAddMessage(text, sender, isTyping = false) {
            const div = document.createElement('div');
            const id = 'msg_' + Math.random().toString(36).substr(2, 9);
            div.id = id;
            div.className = 'slc-message slc-' + sender;
            if (isTyping) div.className += ' slc-typing';
            div.textContent = text;
            
            const container = document.getElementById('slc-chat-messages');
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
            
            return id;
        }

        function slcAddFeedback(elemId, logId) {
            const div = document.getElementById(elemId);
            if (!div) return;
            
            const feedbackDiv = document.createElement('div');
            feedbackDiv.className = 'slc-feedback';
            feedbackDiv.innerHTML = 'Was this helpful? <button onclick="slcSendFeedback(' + logId + ', true, this)" title="Helpful">👍</button> <button onclick="slcSendFeedback(' + logId + ', false, this)" title="Not helpful">👎</button>';
            div.appendChild(feedbackDiv);
        }

        async function slcSendFeedback(logId, isHelpful, btn) {
            try {
                await fetch('<?php echo esc_url(rest_url('simple-llm/v1/feedback')); ?>', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                    },
                    body: JSON.stringify({ 
                        log_id: logId, 
                        is_helpful: isHelpful 
                    })
                });
                
                // Mark button as selected
                btn.classList.add('selected');
                btn.parentElement.querySelectorAll('button').forEach(b => {
                    if (b !== btn) b.disabled = true;
                });
                
            } catch (err) {
                console.error('Feedback error:', err);
            }
        }
    </script>
    <?php
}

/**
 * ADD SETTINGS LINK ON PLUGINS PAGE
 */
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'slc_add_settings_link');
function slc_add_settings_link($links) {
    $settings_link = '<a href="' . admin_url('options-general.php?page=simple-llm-chatbot') . '">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
