<?php
if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $name_parts = explode(' ', $current_user->display_name);
    $first_name = $name_parts[0]; // Перше ім'я
    $last_name = isset($name_parts[1]) ? $name_parts[1] : ''; // Прізвище, якщо існує
    $phone_number = get_user_meta($user_id, 'phone_number', true);
}

?>

<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Make an Appointment</h2>
                <h4>Select the Time</h4>
            </div>
            <div class="modal-body">
                <div class="times">
                    <form id="zabuto-form" method="post">
                        <input type="hidden" name="user_id" value="<?php echo esc_attr($current_user->ID); ?>">
                        <input type="hidden" id="modal-date" name="date" value=""> <!-- Поле для дати -->
                        <input type="hidden" id="modal-time" name="time" value=""> <!-- Поле для часу -->
                        <input type="hidden" id="modal-first-name" name="modal-first-name" value="<?php echo esc_attr($first_name); ?>">
                        <input type="hidden" id="modal-last-name" name="modal-last-name" value="<?php echo esc_attr($last_name); ?>">
                        <input type="hidden" id="modal-email" name="modal-email" value="<?php echo esc_attr($current_user->user_email); ?>">
                        <input type="hidden" id="modal-number" name="modal-number" value="<?php echo esc_attr($phone_number); ?>">
                        <div class="btn-group" data-toggle="buttons">
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button type="submit" class="btn pull-right btn-primary" id="form-contact-submit">Continue</button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.times -->
            </div><!-- /.modal-body -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


