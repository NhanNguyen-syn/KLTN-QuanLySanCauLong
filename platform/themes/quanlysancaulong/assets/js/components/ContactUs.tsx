import { defineComponent, h } from 'vue';

export default defineComponent({
    name: 'ContactUs',
    props: {
        formTitle: String,
        formSubtitle: String,
        contactFormHtml: String, // HTML for the contact form, rendered by the server
        locationTitle: String,
        googleMapsIframe: String,
        mainBranchTitle: String,
        mainBranchAddress: String,
        mainBranchPhone: String,
        mainBranchMapUrl: String,
        otherBranchesTitle: String,
        otherBranches: Array as () => { name: string; address: string; map_url: string }[],
    },
    setup(props) {
        const renderLocation = () => (
            <div class="location-wrapper">
                {props.locationTitle && <h3>{props.locationTitle}</h3>}
                {props.googleMapsIframe && (
                    <div class="google-map-container" innerHTML={props.googleMapsIframe}></div>
                )}
                <div class="branch-info">
                    {props.mainBranchTitle && <h4>{props.mainBranchTitle}</h4>}
                    {props.mainBranchAddress && <p class="address">{props.mainBranchAddress}</p>}
                    {props.mainBranchPhone && <p class="phone">{props.mainBranchPhone}</p>}
                    {props.mainBranchMapUrl && (
                        <a href={props.mainBranchMapUrl} class="directions-link" target="_blank" rel="noopener noreferrer">
                            Chỉ đường
                        </a>
                    )}
                </div>
                {props.otherBranches && props.otherBranches.length > 0 && (
                    <div class="branch-info other-branches">
                        {props.otherBranchesTitle && <h4>{props.otherBranchesTitle}</h4>}
                        {props.otherBranches.map((branch, index) => (
                            <div class="branch-item" key={index}>
                                {branch.name && <h5>{branch.name}</h5>}
                                {branch.address && <p class="address">{branch.address}</p>}
                                {branch.map_url && (
                                    <a href={branch.map_url} class="directions-link" target="_blank" rel="noopener noreferrer">
                                        Chỉ đường
                                    </a>
                                )}
                            </div>
                        ))}
                    </div>
                )}
            </div>
        );

        const renderForm = () => (
            <div class="contact-form-wrapper">
                {props.formTitle && <h3>{props.formTitle}</h3>}
                {props.formSubtitle && <p>{props.formSubtitle}</p>}
                {/* Render the server-side generated contact form */}
                <div innerHTML={props.contactFormHtml}></div>
            </div>
        );

        return () => (
            <section class="contact-us-section">
                <div class="container">
                    <div class="contact-us-grid">
                        {renderForm()}
                        {renderLocation()}
                    </div>
                </div>
            </section>
        );
    },
});

