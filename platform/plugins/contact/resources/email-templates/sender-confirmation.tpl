{{ header }}

<div class="bb-main-content">
    <table class="bb-box" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td class="bb-content bb-pb-0" align="center">
                    <table class="bb-icon bb-icon-lg bb-bg-blue" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td valign="middle" align="center">
                                    <img src="{{ 'mail' | icon_url }}" class="bb-va-middle" width="40" height="40" alt="Icon">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h1 class="bb-text-center bb-m-0 bb-mt-md">Xác nhận liên hệ</h1>
                </td>
            </tr>
            <tr>
                <td class="bb-content">
                    <p>Xin chào {{ contact_name }},</p>

                    <p>Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi đã nhận được tin nhắn của bạn và sẽ phản hồi trong thời gian sớm nhất.</p>

                    <div class="bb-content-block">
                        <h4>Thông tin liên hệ của bạn:</h4>
                        <table class="bb-table" cellspacing="0" cellpadding="0">
                            <tbody>
                                {% if contact_email %}
                                <tr>
                                    <td width="120"><strong>Email:</strong></td>
                                    <td>{{ contact_email }}</td>
                                </tr>
                                {% endif %}
                                {% if contact_phone %}
                                <tr>
                                    <td><strong>Điện thoại:</strong></td>
                                    <td>{{ contact_phone }}</td>
                                </tr>
                                {% endif %}
                            </tbody>
                        </table>
                    </div>

                    {% if contact_content %}
                    <div class="bb-content-block bb-mt-lg">
                        <h4>Nội dung tin nhắn:</h4>
                        <p><i>{{ contact_content }}</i></p>
                    </div>
                    {% endif %}

                    <p class="bb-mt-lg">Trân trọng,<br>{{ site_title }}</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

{{ footer }}
