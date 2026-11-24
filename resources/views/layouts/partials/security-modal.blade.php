<!-- Security Settings Modal (Change Password) -->
<div class="modal fade sec-modal" id="securitySettingsModal" tabindex="-1" aria-labelledby="securitySettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="sec-hd">
                    <span class="sec-ico"><i class="fas fa-shield-halved"></i></span>
                    <div>
                        <h5 class="modal-title" id="securitySettingsModalLabel" data-i18n="Security Settings">Security Settings</h5>
                        <p>Keep your account safe with a strong password</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body password-section">
                <h6 data-i18n="Change Password">Change Password</h6>

                <div class="form-group sec-field">
                    <label for="currentPassword" data-i18n="Current Password">Current Password</label>
                    <div class="sec-input"><i class="fas fa-lock lead"></i>
                        <input type="password" class="form-control" id="currentPassword" placeholder="••••••••" autocomplete="current-password">
                        <button type="button" class="eye" data-sec-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
                    </div>
                </div>

                <div class="form-group sec-field">
                    <label for="newPassword" data-i18n="New Password">New Password</label>
                    <div class="sec-input"><i class="fas fa-key lead"></i>
                        <input type="password" class="form-control" id="newPassword" placeholder="••••••••" autocomplete="new-password">
                        <button type="button" class="eye" data-sec-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
                    </div>

                    <!-- Password Strength Meter -->
                    <div class="sec-meter">
                        <div class="progress flex-grow-1">
                            <div class="progress-bar" id="strengthBar" role="progressbar" style="width: 0%;"></div>
                        </div>
                        <small class="fw-bold" id="strengthText" style="font-size: 0.75rem; min-width: 48px; text-align: right;"></small>
                    </div>

                    <div class="sec-tips" id="secTips">
                        <span data-tip="len">8+ characters</span>
                        <span data-tip="case">Aa mixed case</span>
                        <span data-tip="num">Number</span>
                        <span data-tip="sym">Symbol</span>
                    </div>
                </div>

                <div class="form-group sec-field mb-0">
                    <label for="confirmPassword" data-i18n="Confirm New Password">Confirm New Password</label>
                    <div class="sec-input"><i class="fas fa-lock lead"></i>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="••••••••" autocomplete="new-password">
                        <button type="button" class="eye" data-sec-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
                    </div>
                    <div class="sec-hint" id="secMatch"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-i18n="Cancel">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveSecuritySettings"><i class="fas fa-check me-1"></i> <span data-i18n="Save Changes">Save Changes</span></button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var m = document.getElementById('securitySettingsModal');
    if (!m) return;

    m.querySelectorAll('[data-sec-eye]').forEach(function (b) {
        b.addEventListener('click', function () {
            var i = b.parentElement.querySelector('input');
            var show = i.type === 'password';
            i.type = show ? 'text' : 'password';
            b.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });

    var np = document.getElementById('newPassword'), cp = document.getElementById('confirmPassword'), hint = document.getElementById('secMatch');
    function tip(k, ok) { var el = m.querySelector('[data-tip="' + k + '"]'); if (el) el.classList.toggle('ok', ok); }
    function check() {
        var v = np.value;
        tip('len', v.length >= 8);
        tip('case', /[a-z]/.test(v) && /[A-Z]/.test(v));
        tip('num', /\d/.test(v));
        tip('sym', /[^A-Za-z0-9]/.test(v));
        if (cp.value) {
            var ok = cp.value === v;
            hint.textContent = ok ? 'Passwords match' : 'Passwords do not match yet';
            hint.style.color = ok ? '#16A34A' : '#DC2626';
        } else { hint.textContent = ''; }
    }
    np.addEventListener('input', check);
    cp.addEventListener('input', check);
    m.addEventListener('hidden.bs.modal', function () {
        m.querySelectorAll('input').forEach(function (i) { i.value = ''; i.type = 'password'; });
        m.querySelectorAll('[data-sec-eye] i').forEach(function (i) { i.className = 'fas fa-eye'; });
        check();
    });
})();
</script>