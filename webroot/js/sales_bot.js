/* Sales Bot - Dynamic Conversation Engine */
document.addEventListener('DOMContentLoaded', function() {
    const bubble = document.getElementById('sales-bot-bubble');
    const window = document.getElementById('sales-bot-window');
    const closeBtn = document.getElementById('sales-bot-close');
    const sendBtn = document.getElementById('sales-bot-send');
    const input = document.getElementById('sales-bot-input');
    const messages = document.getElementById('sales-bot-messages');
    const typing = document.getElementById('bot-typing');

    // Conversation State
    let step = 0;
    const userData = {
        first_name: '',
        last_name: '',
        company_name: '',
        email: '',
        message: '',
        source: 'SalesBot',
        company_id: window.BotConfig ? window.BotConfig.company_id : 1
    };

    const questions = [
        "Welcome! I'm the ESCerp Assistant. I'd love to help you get started. What's your first name?",
        "Nice to meet you, {name}! And your last name?",
        "Great! What company are you with?",
        "Perfect. What's a good email address to reach you at?",
        "Last thing - how can we help you specifically today?"
    ];

    // 1. UI Handlers
    bubble.addEventListener('click', () => {
        window.classList.toggle('active');
        if (window.classList.contains('active') && step === 0) startConversation();
    });

    closeBtn.addEventListener('click', () => window.classList.remove('active'));

    sendBtn.addEventListener('click', processInput);
    input.addEventListener('keypress', (e) => { if (e.key === 'Enter') processInput(); });

    // 2. Bot Logic
    function startConversation() {
        showBotMessage(questions[0]);
        step = 1;
    }

    function processInput() {
        const val = input.value.trim();
        if (!val) return;

        addMessage(val, 'user-msg');
        input.value = '';

        // State Machine
        switch(step) {
            case 1:
                userData.first_name = val;
                step++;
                showBotMessage(questions[1].replace('{name}', userData.first_name));
                break;
            case 2:
                userData.last_name = val;
                step++;
                showBotMessage(questions[2]);
                break;
            case 3:
                userData.company_name = val;
                step++;
                showBotMessage(questions[3]);
                break;
            case 4:
                if (!validateEmail(val)) {
                    showBotMessage("Hmm, that email doesn't look quite right. Could you try again?");
                } else {
                    userData.email = val;
                    step++;
                    showBotMessage(questions[4]);
                }
                break;
            case 5:
                userData.message = val;
                step++;
                submitLead();
                break;
        }
    }

    function showBotMessage(txt) {
        typing.style.display = 'block';
        setTimeout(() => {
            typing.style.display = 'none';
            addMessage(txt, 'bot-msg');
        }, 1200);
    }

    function addMessage(txt, cls) {
        const div = document.createElement('div');
        div.className = cls;
        div.textContent = txt;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function validateEmail(email) {
        return String(email)
            .toLowerCase()
            .match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    }

    // 3. Submission Logic
    function submitLead() {
        showBotMessage("Working on it... ⚙️");

        // The secure token and base URL
        const token = 'SECURE_WEBHOOK_KEY_123';
        const baseUrl = window.BotConfig ? window.BotConfig.baseUrl : '';
        const url = `${baseUrl}/deal-requests/webhook?token=${token}`;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(userData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showBotMessage("All set! Thanks " + userData.first_name + ". One of our sales experts will contact you shortly.");
                input.disabled = true;
                sendBtn.disabled = true;
            } else {
                showBotMessage("Oops, I had a bit of trouble saving that. Could you try submitting again later?");
            }
        })
        .catch(err => {
            console.error('Bot Error:', err);
            showBotMessage("Something went wrong on our end. Please reach out to us at sales@example.com directly.");
        });
    }

    // Optional: Auto-open after delay
    setTimeout(() => {
        if (!window.classList.contains('active')) {
            bubble.style.boxShadow = '0 6px 25px rgba(110, 142, 251, 0.8)';
            setTimeout(() => bubble.style.boxShadow = '', 2000);
        }
    }, 5000);
});
