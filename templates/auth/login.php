<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Secure Gateway Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-100/70 overflow-hidden transition-all duration-300">
        
        <div class="p-8 pb-4 border-b border-slate-100 bg-slate-50/50 text-center">
            <div class="inline-flex bg-emerald-600 text-white p-3 rounded-2xl shadow-md shadow-emerald-100 mb-4">
                <i data-lucide="shield-check" class="w-7 h-7"></i>
            </div>
            <h1 class="font-bold text-2xl text-slate-900 tracking-tight">PharmaFEFO Gateway</h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Authorized Clinical & Inventory Access Only</p>
        </div>

        <form id="login-form" onsubmit="handleAuthSubmit(event)" class="p-8 space-y-5" novalidate>
            
            <div id="global-auth-error" class="hidden flex items-start gap-3 bg-rose-50 border border-rose-200 text-rose-800 p-3 rounded-xl text-xs font-medium">
                <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 text-rose-600 mt-0.5"></i>
                <span id="global-error-text">Invalid authentication tokens.</span>
            </div>

            <div class="space-y-1.5">
                <label for="auth-email" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Clinical Email Address</label>
                <div class="relative">
                    <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
                    <input type="email" id="auth-email" oninput="validateFormInputs()" placeholder="name@pharma.com" class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/30 font-medium placeholder-slate-400 transition-all">
                </div>
                <p id="email-error-msg" class="text-xs text-rose-600 font-medium hidden pl-1"></p>
            </div>

            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="auth-password" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Security Password</label>
                    <button type="button" onclick="triggerPasswordRecovery()" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline transition-all">Forgot Password?</button>
                </div>
                <div class="relative">
                    <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
                    <input type="password" id="auth-password" oninput="validateFormInputs()" placeholder="••••••••" class="w-full pl-9 pr-12 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50/30 font-medium placeholder-slate-400 transition-all">
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
                        <i data-lucide="eye" id="eye-icon" class="w-4 h-4"></i>
                    </button>
                </div>
                <p id="password-error-msg" class="text-xs text-rose-600 font-medium hidden pl-1"></p>
            </div>

            <div class="pt-2">
                <button type="submit" id="submit-auth-btn" disabled class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl shadow-md disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-emerald-600 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="key-round" class="w-4 h-4"></i> Authenticate Credentials
                </button>
            </div>
        </form>

        <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 text-center">
            <button onclick="toggleDemoHelper()" class="text-xs font-medium text-slate-500 hover:text-slate-800 flex items-center justify-center gap-1 mx-auto transition-all">
                <i data-lucide="info" class="w-3.5 h-3.5"></i> Show Sandbox Environment Demo Roles
            </button>
            
            <div id="demo-helper-panel" class="hidden mt-3 p-3 bg-white border border-slate-200 rounded-xl text-left text-xs space-y-2">
                <p class="font-bold text-slate-600 mb-1">Click a sandbox user to auto-fill profiles:</p>
                <div class="grid grid-cols-1 gap-1.5 font-medium">
                    <button type="button" onclick="injectMockCredentials('admin@pharma.com')" class="text-left p-1.5 hover:bg-slate-50 rounded border border-slate-100 flex justify-between">
                        <span class="text-slate-700">👨‍💻 System Admin</span><span class="text-emerald-600 font-mono">ADMIN</span>
                    </button>
                    <button type="button" onclick="injectMockCredentials('pharmacie@pharma.com')" class="text-left p-1.5 hover:bg-slate-50 rounded border border-slate-100 flex justify-between">
                        <span class="text-slate-700">🧑‍⚕️ Supervisor</span><span class="text-amber-600 font-mono">PHARMACIEN</span>
                    </button>
                    <button type="button" onclick="injectMockCredentials('stock@pharma.com')" class="text-left p-1.5 hover:bg-slate-50 rounded border border-slate-100 flex justify-between">
                        <span class="text-slate-700">👨‍⚕️ Stock Manager</span><span class="text-blue-600 font-mono">PREPARATEUR</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="success-overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full text-center space-y-4 border border-slate-100 shadow-2xl animate-in fade-in zoom-in-95 duration-200">
            <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-slate-900">Access Granted</h3>
                <p id="success-routing-message" class="text-sm text-slate-500 mt-1">Initializing user environment permissions...</p>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl text-xs font-mono font-bold text-slate-600 border border-slate-200/60" id="success-role-badge">
                ROLE: ACCESS_LEVEL
            </div>
            <button onclick="window.location.reload()" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-semibold transition-all">
                Enter Terminal Space
            </button>
        </div>
    </div>

    <script>
        // CLIENT RE-USABLE DATA ARRAYS MOCK ENVIRONMENT
        const users = [
            { email: "admin@pharma.com", password: "123456", role: "ADMIN" },
            { email: "pharmacie@pharma.com", password: "123456", role: "PHARMACIEN" },
            { email: "stock@pharma.com", password: "123456", role: "PREPARATEUR" }
        ];

        // INIT ICONS ENGINE
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });

        // REAL-TIME COMPREHENSIVE INPUT INPUT VALIDATION
        function validateFormInputs() {
            const emailInput = document.getElementById('auth-email');
            const passwordInput = document.getElementById('auth-password');
            const emailError = document.getElementById('email-error-msg');
            const passwordError = document.getElementById('password-error-msg');
            const submitBtn = document.getElementById('submit-auth-btn');

            let isEmailValid = false;
            let isPasswordValid = false;

            // Strict matching standard formatting expressions (RegEx)
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Clear global notification states on input
            document.getElementById('global-auth-error').classList.add('hidden');

            // Evaluate Email String
            if (emailInput.value.trim() === "") {
                emailError.classList.add('hidden');
            } else if (!emailRegex.test(emailInput.value)) {
                emailError.innerText = "Please input a structurally sound clinical email pattern.";
                emailError.classList.remove('hidden');
            } else {
                emailError.classList.add('hidden');
                isEmailValid = true;
            }

            // Evaluate Password Strength Boundaries
            if (passwordInput.value === "") {
                passwordError.classList.add('hidden');
            } else if (passwordInput.value.length < 6) {
                passwordError.innerText = "Security protocol requires passwords containing at least 6 characters.";
                passwordError.classList.remove('hidden');
            } else {
                passwordError.classList.add('hidden');
                isPasswordValid = true;
            }

            // Form Action Control Interlock Gate toggles
            if (isEmailValid && isPasswordValid) {
                submitBtn.removeAttribute('disabled');
            } else {
                submitBtn.setAttribute('disabled', 'true');
            }
        }

        // CONTROL AUTHENTICATION PROCESSING INTERACTION PIPELINES
        function handleAuthSubmit(event) {
            event.preventDefault();
            
            const emailValue = document.getElementById('auth-email').value.trim();
            const passwordValue = document.getElementById('auth-password').value;
            const globalError = document.getElementById('global-auth-error');
            const globalErrorText = document.getElementById('global-error-text');

            // Search simulation user lookup matrix match arrays
            const matchedUser = users.find(u => u.email.toLowerCase() === emailValue.toLowerCase() && u.password === passwordValue);

            if (matchedUser) {
                // Clear errors and simulate state injection transitions
                globalError.classList.add('hidden');
                
                const overlay = document.getElementById('success-overlay');
                const roleBadge = document.getElementById('success-role-badge');
                const routeMsg = document.getElementById('success-routing-message');
                
                roleBadge.innerText = `GRANTED ACCESS CLEARANCE: ${matchedUser.role}`;
                
                // Customize environmental messages context maps
                if (matchedUser.role === 'ADMIN') {
                    routeMsg.innerText = "System configurations unlocked. Redirecting to core administration master systems panel.";
                    roleBadge.className = "p-3 bg-purple-50 text-purple-800 rounded-xl text-xs font-mono font-bold border border-purple-200";
                } else if (matchedUser.role === 'PHARMACIEN') {
                    routeMsg.innerText = "Supervisor interface localized. Loading clinical approval desks and validation tools.";
                    roleBadge.className = "p-3 bg-amber-50 text-amber-800 rounded-xl text-xs font-mono font-bold border border-amber-200";
                } else {
                    routeMsg.innerText = "Stock manager environment prepared. Preparing FEFO item arrival queues.";
                    roleBadge.className = "p-3 bg-blue-50 text-blue-800 rounded-xl text-xs font-mono font-bold border border-blue-200";
                }

                overlay.classList.remove('hidden');
            } else {
                // Return failed evaluation validation responses securely
                globalErrorText.innerText = "Authentication failed. Access denied. Please evaluate email configuration paths or validation keys.";
                globalError.classList.remove('hidden');
            }
        }

        // INTERACTION INTERFACE HELPER WRAPPERS
        function togglePasswordVisibility() {
            const passInput = document.getElementById('auth-password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passInput.type === "password") {
                passInput.type = "text";
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passInput.type = "password";
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        function triggerPasswordRecovery() {
            alert("Security Protocol Info:\nPassword recovery events require authorization keys from internal hardware administrators. Please reach out directly to your site IT Desk manager.");
        }

        function toggleDemoHelper() {
            document.getElementById('demo-helper-panel').classList.toggle('hidden');
        }

        function injectMockCredentials(email) {
            document.getElementById('auth-email').value = email;
            document.getElementById('auth-password').value = "123456";
            validateFormInputs();
        }
    </script>
</body>
</html>