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
                    <h1 class="bb-text-center bb-m-0 bb-mt-md">Thông báo liên hệ mới</h1>
                </td>
            </tr>
            <tr>
                <td class="bb-content">
                    <p>Bạn nhận được một liên hệ mới từ website:</p>

                    <table class="bb-table" cellspacing="0" cellpadding="0">
                        <tbody>
                            {% if contact_name %}
                            <tr>
                                <td width="120"><strong>Họ tên:</strong></td>
                                <td>{{ contact_name }}</td>
                            </tr>
                            {% endif %}
                            {% if contact_email %}
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ contact_email }}</td>
                            </tr>
                            {% endif %}
                            {% if contact_phone %}
                            <tr>
                                <td><strong>Điện thoại:</strong></td>
                                <td>{{ contact_phone }}</td>
                            </tr>
                            {% endif %}
                            {% if contact_subject %}
                            <tr>
                                <td><strong>Tiêu đề:</strong></td>
                                <td>{{ contact_subject }}</td>
                            </tr>
                            {% endif %}
                            {% if contact_address %}
                            <tr>
                                <td><strong>Địa chỉ:</strong></td>
                                <td>{{ contact_address }}</td>
                            </tr>
                            {% endif %}
                        </tbody>
                    </table>

                    {% if contact_content %}
                    <div class="bb-content-block bb-mt-lg">
                        <h4>Nội dung:</h4>
                        <p>{{ contact_content }}</p>
                    </div>
                    {% endif %}
                </td>
            </tr>
        </tbody>
    </table>
</div>

{{ footer }}
