import { defineComponent, ref } from 'vue';
import axios from 'axios';

const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
  (axios.defaults.headers.common['X-CSRF-TOKEN'] as any) = (token as HTMLMetaElement).content;
}

export default defineComponent({
  name: 'ContactForm',
  props: {
    title: { type: String, required: true },
    subtitle: { type: String, default: '' },
    titleColor: { type: String, required: true },
    labelName: { type: String, required: true },
    labelPhone: { type: String, required: true },
    labelEmail: { type: String, required: true },
    labelSubject: { type: String, default: '' },
    labelMessage: { type: String, required: true },
    buttonText: { type: String, required: true },
    buttonColor: { type: String, required: true },
    buttonTextColor: { type: String, required: true },
    successMessage: { type: String, required: true },
    errorMessage: { type: String, required: true },
    contactFormUrl: { type: String, required: true },
    hasRecaptcha: { type: Boolean, default: false },
    enableHoneypot: { type: Boolean, default: true },
  },
  setup(props) {
    const id = (p: string) => `cf-${p}-${Math.random().toString(36).slice(2, 8)}`;

    const name = ref('');
    const phone = ref('');
    const email = ref('');
    const subject = ref('');
    const content = ref('');
    const agree = ref(false);
    const honeypot = ref('');

    const errors = ref<Record<string, string>>({});
    const isLoading = ref(false);
    const alertMsg = ref('');
    const alertType = ref<'success' | 'error' | ''>('');

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[+]?\d{6,15}$/;

    const validate = () => {
      errors.value = {};
      if (!name.value.trim()) errors.value.name = 'Vui lòng nhập họ và tên';
      if (!content.value.trim()) errors.value.content = 'Vui lòng nhập nội dung';
      if (!email.value.trim() && !phone.value.trim()) errors.value.contact = 'Cần nhập Email hoặc Số điện thoại';
      if (email.value && !emailRegex.test(email.value)) errors.value.email = 'Email không hợp lệ';
      if (phone.value && !phoneRegex.test(phone.value)) errors.value.phone = 'Số điện thoại không hợp lệ';
      if (!agree.value) errors.value.agree = 'Bạn cần đồng ý điều khoản';
      return Object.keys(errors.value).length === 0;
    };

    const resetForm = () => {
      name.value = phone.value = email.value = subject.value = content.value = '';
      agree.value = false; honeypot.value = '';
    };

    const submit = async () => {
      if (!validate()) return;
      isLoading.value = true; alertMsg.value = ''; alertType.value = '';
      try {
        const payload: any = {
          name: name.value,
          phone: phone.value,
          email: email.value,
          subject: subject.value,
          content: content.value,
          agree_terms_and_policy: agree.value ? 1 : 0,
        };
        if (props.enableHoneypot) payload['website'] = honeypot.value; // typical honeypot field name

        const res = await axios.post(props.contactFormUrl, payload, { headers: { Accept: 'application/json' } });
        if (res.data && res.data.error === false) {
          alertMsg.value = props.successMessage; alertType.value = 'success';
          resetForm();
          window.dispatchEvent(new CustomEvent('contact-form:success'));
          setTimeout(() => { alertMsg.value = ''; alertType.value = ''; }, 5000);
        } else {
          alertMsg.value = res.data?.message || props.errorMessage; alertType.value = 'error';
          window.dispatchEvent(new CustomEvent('contact-form:fail'));
        }
      } catch (e: any) {
        const srv = e?.response?.data; let msg = '';
        if (srv?.errors) { const k = Object.keys(srv.errors)[0]; msg = srv.errors[k]?.[0]; }
        alertMsg.value = msg || srv?.message || props.errorMessage; alertType.value = 'error';
        console.error('ContactForm submit error:', e);
      } finally {
        isLoading.value = false;
      }
    };

    const titleStyle = { color: props.titleColor } as any;
    const btnStyle = { backgroundColor: props.buttonColor, color: props.buttonTextColor } as any;

    // IDs for a11y
    const idName = id('name');
    const idPhone = id('phone');
    const idEmail = id('email');
    const idSubject = id('subject');
    const idContent = id('content');
    const idAgree = id('agree');

    return () => (
      <div class="cf-form">
        <header class="cf-header">
          <h2 class="cf-title" style={titleStyle}>{props.title}</h2>
          {props.subtitle && <p class="cf-subtitle">{props.subtitle}</p>}
          {alertMsg.value && (
            <div role="alert" aria-live="polite" class={['cf-alert', alertType.value === 'success' ? 'cf-alert-success' : 'cf-alert-error'].join(' ')}>
              {alertMsg.value}
            </div>
          )}
        </header>
        <form class="cf-fields" novalidate onSubmit={(e) => { e.preventDefault(); submit(); }}>
          <div class="cf-field">
            <label for={idName}>{props.labelName} <span aria-hidden="true">*</span></label>
            <input id={idName} type="text" class="cf-input" value={name.value} onInput={(e:any)=>name.value=e.target.value} aria-invalid={!!errors.value.name} aria-describedby={errors.value.name?`${idName}-err`:undefined} />
            {errors.value.name && <p id={`${idName}-err`} class="cf-error">{errors.value.name}</p>}
          </div>

          <div class="cf-field">
            <label for={idPhone}>{props.labelPhone}</label>
            <input id={idPhone} type="tel" class="cf-input" value={phone.value} onInput={(e:any)=>phone.value=e.target.value} aria-invalid={!!(errors.value.phone||errors.value.contact)} aria-describedby={errors.value.phone||errors.value.contact?`${idPhone}-err`:undefined} />
            {(errors.value.phone||errors.value.contact) && <p id={`${idPhone}-err`} class="cf-error">{errors.value.phone||errors.value.contact}</p>}
          </div>

          <div class="cf-field">
            <label for={idEmail}>{props.labelEmail}</label>
            <input id={idEmail} type="email" class="cf-input" value={email.value} onInput={(e:any)=>email.value=e.target.value} aria-invalid={!!(errors.value.email||errors.value.contact)} aria-describedby={errors.value.email||errors.value.contact?`${idEmail}-err`:undefined} />
            {(errors.value.email||errors.value.contact) && <p id={`${idEmail}-err`} class="cf-error">{errors.value.email||errors.value.contact}</p>}
          </div>

          {props.labelSubject && (
            <div class="cf-field">
              <label for={idSubject}>{props.labelSubject}</label>
              <input id={idSubject} type="text" class="cf-input" value={subject.value} onInput={(e:any)=>subject.value=e.target.value} />
            </div>
          )}

          <div class="cf-field cf-field-textarea">
            <label for={idContent}>{props.labelMessage} <span aria-hidden="true">*</span></label>
            <textarea id={idContent} class="cf-textarea" rows={4} value={content.value} onInput={(e:any)=>content.value=e.target.value} aria-invalid={!!errors.value.content} aria-describedby={errors.value.content?`${idContent}-err`:undefined}></textarea>
            {errors.value.content && <p id={`${idContent}-err`} class="cf-error">{errors.value.content}</p>}
          </div>

          {props.enableHoneypot && (
            <div class="cf-honeypot" aria-hidden="true" style="display:none;">
              <label for="website">Website</label>
              <input id="website" type="text" value={honeypot.value} onInput={(e:any)=>honeypot.value=e.target.value} tabindex={-1} autocomplete="off" />
            </div>
          )}

          {props.hasRecaptcha && <div class="cf-recaptcha" />}

          <div class="cf-agree">
            <input id={idAgree} type="checkbox" checked={agree.value} onChange={(e:any)=>agree.value=e.target.checked} aria-invalid={!!errors.value.agree} />
            <label htmlFor={idAgree}>Tôi đồng ý với điều khoản</label>
            {errors.value.agree && <p class="cf-error">{errors.value.agree}</p>}
          </div>

          <button type="submit" class="cf-btn" style={btnStyle} disabled={isLoading.value} aria-busy={isLoading.value}>
            {isLoading.value ? (
              <span class="cf-spinner" aria-hidden="true"></span>
            ) : null}
            <span>{isLoading.value ? 'Đang gửi...' : props.buttonText}</span>
          </button>
        </form>
      </div>
    );
  },
});

