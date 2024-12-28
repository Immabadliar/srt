var _a;
(_a = document.getElementById('joinForm')) === null || _a === void 0 ? void 0 : _a.addEventListener('submit', function (e) {
    e.preventDefault();
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var experience = document.getElementById('experience').value;
    var skills = document.getElementById('skills').value;
    var formData = {
        name: name,
        email: email,
        experience: experience,
        skills: skills
    };
    sendEmail(formData);
});
function sendEmail(data) {
    var emailContent = "\n        New application from ".concat(data.name, " (").concat(data.email, "):\n\n        Experience:\n        ").concat(data.experience, "\n\n        Skills:\n        ").concat(data.skills, "\n    ");
    fetch('/send-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            to: 'lucacocchia1234@gmail.com',
            subject: 'New Application for HDA SRT',
            body: emailContent,
        }),
    })
        .then(function (response) {
        if (response.ok) {
            alert('Your application has been submitted!');
        }
        else {
            alert('There was an error submitting your application.');
        }
    })
        .catch(function (error) {
        console.error('Error:', error);
        alert('There was an error submitting your application.');
    });
}
