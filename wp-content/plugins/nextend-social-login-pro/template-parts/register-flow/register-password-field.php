<div class="user-pass1-wrap">
    <p>
        <label for="pass1"><?php _e('Password') ?></label>
    </p>

    <div class="wp-pwd">
        <div class="password-input-wrapper">
            <input type="password" data-reveal="1" data-pw="<?php echo esc_attr(wp_generate_password(16)); ?>" name="pass1" id="pass1" class="input password-input" size="24" value="" autocomplete="off" aria-describedby="pass-strength-result"/>
            <span class="button button-secondary wp-hide-pw hide-if-no-js">
                        <span class="dashicons dashicons-hidden"></span>
                    </span>
        </div>
        <div id="pass-strength-result" class="hide-if-no-js" aria-live="polite"><?php _e('Strength indicator'); ?></div>
    </div>
    <div class="pw-weak">
        <label>
            <input type="checkbox" name="pw_weak" class="pw-checkbox"/>
            <?php _e('Confirm use of weak password'); ?>
        </label>
    </div>
</div>

<p class="user-pass2-wrap">
    <label for="pass2"><?php _e('Confirm password') ?></label><br/>
    <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off"/>
</p>

<p class="description indicator-hint"><?php echo wp_get_password_hint(); ?></p>
<br class="clear"/>