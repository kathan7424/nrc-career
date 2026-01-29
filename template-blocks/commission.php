<section class="commission-savings-block">
    <div class="container">
        <div class="commission-head">
            <h2 class="title">How much will <span class="em">You Save?</span></h2>
            <p class="subtitle">Please take a minute and do the math for yourself,</p>
            <div class="big-savings">You Will Save Thousands!</div>
        </div>

        <div class="commission-switch">
            <button class="cs-tab active" data-tab="agent">Agent</button>
            <button class="cs-tab" data-tab="family">Family</button>
            <button class="cs-tab" data-tab="team">Team</button>
        </div>

        <div class="calculator-area">
            <div class="calculator-inner">
                <div class="calculator-placeholder" role="img" aria-label="Commission calculator">
                    <!-- Put one dummy image per tab. Replace src with real images as needed. -->
                    <img class="calc-img active" data-tab="agent" src="http://localhost/nrc/wp-content/uploads/2026/01/20240829-Are-We-Heading-into-a-Balanced-Market-original.png" alt="Are we heading into a balanced market" />
                    <img class="calc-img" data-tab="family" src="http://localhost/nrc/wp-content/uploads/2026/01/20240902-Could-a-55-Community-Be-Right-for-You-original.png" alt="Could a 55+ community be right for you" />
                    <img class="calc-img" data-tab="team" src="http://localhost/nrc/wp-content/uploads/2026/01/20240903-Should-You-Sell-Now-The-Lifestyle-Factors-That-Could-Tip-the-Scale-original.png" alt="Should you sell now - lifestyle factors" />
                </div>
            </div>
        </div>

        <div class="commission-cta">NO Hidden Fees, Period!</div>

        <div class="commission-fineprint">
            <div class="fine-grid">
                <div class="fine-list">
                    <div class="fine-item">
                        <div class="term">MONTHLY FEE</div>
                        <div class="desc">$25 per month.</div>
                    </div>

                    <div class="fine-item">
                        <div class="term">YEARLY FEE</div>
                        <div class="desc">$825 per year for your Errors & Omissions liability insurance.</div>
                    </div>

                    <div class="fine-item">
                        <div class="term">BUYERS & SELLERS</div>
                        <div class="desc">We collect $495 on the first 10 closed buyer and seller deals each year; $165 thereafter.</div>
                    </div>

                    <div class="fine-item">
                        <div class="term">COMPLIANCE FEE</div>
                        <div class="desc">Standard compliance fees may apply for certain markets and programs.</div>
                    </div>

                    <div class="fine-item">
                        <div class="term">LANDLORD & TENANTS</div>
                        <div class="desc">$95 for every landlord or tenant represented; local rules may vary.</div>
                    </div>

                    <div class="fine-item">
                        <div class="term">REFERRALS</div>
                        <div class="desc">Referral fees are subject to agreement and local regulations.</div>
                    </div>

                    <div class="support-box">
                        <div class="support-left">
                            <div class="questions">QUESTIONS</div>
                            <p>If you would like to join our NRC Family or if you have questions, please <a href="/contact">contact our Support Team</a>.</p>
                        </div>

                        <div class="chevrons" aria-hidden="true">
                            <!-- two-chevron decorative mark -->
                            <svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
                              <path d="M8 14L24 27L8 40" stroke="#e74c3c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M22 14L38 27L22 40" stroke="#e74c3c" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.commission-switch .cs-tab');
    const images = document.querySelectorAll('.calculator-placeholder .calc-img');

    function activateTab(tabName) {
        tabs.forEach(t => t.classList.toggle('active', t.getAttribute('data-tab') === tabName));
        images.forEach(img => img.classList.toggle('active', img.dataset.tab === tabName));
    }

    tabs.forEach(btn => btn.addEventListener('click', function() {
        const target = this.getAttribute('data-tab');
        activateTab(target);
    }));

    // Allow keyboard navigation: left/right arrows change tab
    document.querySelector('.commission-switch').addEventListener('keydown', function(e) {
        const key = e.key;
        const activeIndex = Array.from(tabs).findIndex(t => t.classList.contains('active'));
        if (key === 'ArrowRight') {
            const next = tabs[(activeIndex + 1) % tabs.length]; next.focus(); next.click();
        } else if (key === 'ArrowLeft') {
            const prev = tabs[(activeIndex - 1 + tabs.length) % tabs.length]; prev.focus(); prev.click();
        }
    });

    // Initialize — ensure first tab active
    if (tabs.length) activateTab(tabs[0].getAttribute('data-tab'));
});
</script>
