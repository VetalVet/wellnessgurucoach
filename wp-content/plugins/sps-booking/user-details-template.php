<div class="wrap">
    <h1>User Details</h1>
    <table class="table table-user-detalies">
        <tr>
            <th>Title</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Name:</td>
            <td><?php echo esc_html($user_meta_data['first_name'] . ' ' . $user_meta_data['last_name']); ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo esc_html($user_meta_data['email']); ?></td>
        </tr>
        <tr>
            <td>Phone Number:</td>
            <td><?php echo esc_html($user_meta_data['phone_number']); ?></td>
        </tr>
        <tr>
            <td>Occupation:</td>
            <td><?php echo esc_html($user_meta_data['occupation']); ?></td>
        </tr>
        <tr>
            <td>Date Of Birth:</td>
            <td><?php echo esc_html($user_meta_data['date_birth']); ?></td>
        </tr>
        <tr>
            <td>Weight:</td>
            <td><?php echo esc_html($user_meta_data['weight']); ?></td>
        </tr>
        <tr>
            <td>Height:</td>
            <td><?php echo esc_html($user_meta_data['height']); ?></td>
        </tr>
        <tr>
            <td>Sex:</td>
            <td><?php echo esc_html($user_meta_data['sex']); ?></td>
        </tr>
        <tr>
            <td>Are you currently taking any medications  and supplements?</td>
            <td><?php echo esc_html($user_meta_data['taking']); ?></td>
        </tr>
        <tr>
            <td>What are your health and wellness goals?</td>
            <td><?php echo esc_html($user_meta_data['wellness_goals']); ?></td>
        </tr>
        <tr>
            <td>List any concerns about your health, eating habits and  fitness rating in order of importance:</td>
            <td><?php echo esc_html($user_meta_data['problems_health']); ?></td>
        </tr>
        <tr>
            <td>What is your current diet like?</td>
            <td><?php echo esc_html($user_meta_data['diet']); ?></td>
        </tr>
        <tr>
            <td>What is your currently exercise routine?:</td>
            <td><?php echo esc_html($user_meta_data['exercise']); ?></td>
        </tr>
        <tr>
            <td>What is your stress level on scale of 1 through 10, 10 being the highest?:</td>
            <td><?php echo esc_html($user_meta_data['stress']); ?></td>
        </tr>

        <tr>
            <td>How much sleep do you get per night?</td>
            <td><?php echo esc_html($user_meta_data['sleep']); ?></td>
        </tr>
        <tr>
            <td>Do you have any chronic health conditions?</td>
            <td><?php echo esc_html($user_meta_data['chronic_conditions']); ?></td>
        </tr>
        <tr>
            <td>Do you have any mental health issues?</td>
            <td><?php echo esc_html($user_meta_data['mental_health']); ?></td>
        </tr>
        <tr>
            <td>What are your short term goals?</td>
            <td><?php echo esc_html($user_meta_data['short_term_goals']); ?></td>
        </tr>
        <tr>
            <td>What are your long term goals?</td>
            <td><?php echo esc_html($user_meta_data['long_term_goals']); ?></td>
        </tr>

    </table>
</div>
