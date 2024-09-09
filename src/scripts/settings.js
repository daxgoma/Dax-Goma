document.addEventListener('DOMContentLoaded', function() {
    const settingsPopup = document.getElementById('settingsPopup');
    const settingsBtn = document.getElementById('settingsBtn');
    const closeSettingsBtn = document.getElementById('closeSettingsBtn');
    const settingTitles = document.querySelectorAll('#settingTitles li');
    const settingBoxes = document.querySelectorAll('.setting-box');

    // Show the settings popup when the settings button is clicked
    settingsBtn.addEventListener('click', function() {
        settingsPopup.style.display = 'flex';
        window.style.overflow = 'hidden';
    });

    // Hide the settings popup when clicking outside of the content
    settingsPopup.addEventListener('click', function(event) {
        if (event.target === settingsPopup) {
            settingsPopup.style.display = 'none';
            window.style.overflow = 'auto';
        }
    });

    closeSettingsBtn.addEventListener('click', function(event) {
        settingsPopup.style.display = 'none';
        window.style.overflow = 'auto';
    });

    // Function to handle switching between setting sections
    function switchSetting(index) {
        // Remove active class from all titles and boxes
        settingTitles.forEach(item => item.classList.remove('bg-black', 'text-white', 'active'));
        settingBoxes.forEach(box => box.classList.remove('active'));

        // Add active class to the clicked title and corresponding content box
        settingTitles[index].classList.add('bg-black', 'text-white', 'active');
        settingBoxes[index].classList.add('active');
    }

    // Add click events to each setting title
    settingTitles.forEach((li, index) => {
        li.addEventListener('click', function() {
            switchSetting(index);  // Switch to the clicked setting
            localStorage.setItem('activeTab', index); // Save the active tab index
        });
    });

    // Set the default active section (e.g., first one) based on localStorage
    const storedActiveTab = localStorage.getItem('activeTab');
    if (storedActiveTab !== null) {
        switchSetting(parseInt(storedActiveTab, 10)); // Use stored value
    } else {
        switchSetting(0); // Default to the first tab if no stored value
    }

    // Security section
    const adminIdentity = document.getElementById('adminIdentity');
    const adminPassword = document.getElementById('adminPassword');
    const authIdentity = document.getElementById('authIdentity');
    const authPassword = document.getElementById('authPassword');

    let originalAdminValues = {};
    let originalAuthValues = {};

    function fetchSecurityData() {
        fetch('../src/php/security.php', { method: 'GET' })
            .then(response => response.json())
            .then(data => {
                if (data.admin) {
                    adminIdentity.value = data.admin.identity;
                    adminPassword.value = data.admin.password;
                    originalAdminValues = { adminIdentity: adminIdentity.value, adminPassword: adminPassword.value };
                }
                if (data.auth) {
                    authIdentity.value = data.auth.identity;
                    authPassword.value = data.auth.password;
                    originalAuthValues = { authIdentity: authIdentity.value, authPassword: authPassword.value };
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Admin form submission
    document.querySelector('form#adminForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const adminData = { admin: { identity: adminIdentity.value, password: adminPassword.value } };

        fetch('../src/php/security.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(adminData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                localStorage.setItem('popupOpen', 'true'); // Keep popup open after refresh
                // No need to set active tab index here
                location.reload(); // Reload the page
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Admin form reset
    document.querySelector('#adminResetButton').addEventListener('click', function(event) {
        event.preventDefault();
        adminIdentity.value = originalAdminValues.adminIdentity;
        adminPassword.value = originalAdminValues.adminPassword;
    });

    // Auth form submission
    document.querySelector('form#authForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const authData = { auth: { identity: authIdentity.value, password: authPassword.value } };

        fetch('../src/php/security.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(authData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                localStorage.setItem('popupOpen', 'true'); // Keep popup open after refresh
                // No need to set active tab index here
                location.reload(); // Reload the page
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Auth form reset
    document.querySelector('#authResetButton').addEventListener('click', function(event) {
        event.preventDefault();
        authIdentity.value = originalAuthValues.authIdentity;
        authPassword.value = originalAuthValues.authPassword;
    });

    fetchSecurityData();
});



// Web Contents

document.addEventListener('DOMContentLoaded', function() {
    const webContentForm = document.getElementById('webContentSettings');
    const resetButton = document.getElementById('webContentResetForm');
    const brandName = document.getElementById('brandName');
    const brandNameFirst = document.getElementById('brandNameFirst');
    const brandNameSec = document.getElementById('brandNameSec');
    const brandBio = document.getElementById('brandBio');
    const brandEmail = document.getElementById('brandEmail');
    const brandTel = document.getElementById('brandTel');
    const devVisibility = document.getElementsByName('devVisivility');
    const settingsPopup = document.getElementById('settingsPopup'); // Ensure this ID matches your popup's ID

    let originalValues = {};

    function fetchWebContentData() {
        fetch('../src/php/webContents.php', { method: 'GET' })
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    brandName.value = data.brandName || '';
                    brandNameFirst.value = data.brandNameFirst || '';
                    brandNameSec.value = data.brandNameSec || '';
                    brandBio.value = data.brandBio || '';
                    brandEmail.value = data.brandEmail || '';
                    brandTel.value = data.brandTel || '';
                    devVisibility.forEach(radio => {
                        if (radio.value === data.devVisivility) {
                            radio.checked = true;
                        }
                    });
                    originalValues = {
                        brandName: brandName.value,
                        brandNameFirst: brandNameFirst.value,
                        brandNameSec: brandNameSec.value,
                        brandBio: brandBio.value,
                        brandEmail: brandEmail.value,
                        brandTel: brandTel.value,
                        devVisivility: data.devVisivility
                    };
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    webContentForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = {
            brandName: brandName.value,
            brandNameFirst: brandNameFirst.value,
            brandNameSec: brandNameSec.value,
            brandBio: brandBio.value,
            brandEmail: brandEmail.value,
            brandTel: brandTel.value,
            devVisivility: [...devVisibility].find(radio => radio.checked)?.value || ''
        };

        fetch('../src/php/webContents.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                localStorage.setItem('popupOpen', 'true'); // Keep popup open after refresh
                location.reload(); // Refresh the page
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    resetButton.addEventListener('click', function(event) {
        event.preventDefault();
        brandName.value = originalValues.brandName;
        brandNameFirst.value = originalValues.brandNameFirst;
        brandNameSec.value = originalValues.brandNameSec;
        brandBio.value = originalValues.brandBio;
        brandEmail.value = originalValues.brandEmail;
        brandTel.value = originalValues.brandTel;
        devVisibility.forEach(radio => {
            radio.checked = (radio.value === originalValues.devVisivility);
        });
    });

    // Check if the popup should stay open
    function checkPopupStatus() {
        if (localStorage.getItem('popupOpen') === 'true') {
            settingsPopup.style.display = 'flex'; // Ensure the popup is visible
            localStorage.removeItem('popupOpen'); // Clear the flag
        }
    }

    fetchWebContentData();
    checkPopupStatus(); // Check popup status on page load
});
