document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const receiverName = urlParams.get('receiverName');
    const receiverAccountNumber = urlParams.get('receiverAccountNumber');
    const receiverBalance = parseFloat(urlParams.get('receiverBalance'));

    if (receiverName && receiverAccountNumber && !isNaN(receiverBalance)) {
        document.getElementById('receiver-name').value = receiverName;
        document.getElementById('receiver-account-number').value = receiverAccountNumber;
        document.getElementById('receiver-balance').textContent = `$${receiverBalance.toFixed(2)}`;

        // Placeholder for MY data
        const sender = {
            name: 'Manish',
            balance: 1000
        };

        document.getElementById('sender-balance').textContent = `$${sender.balance.toFixed(2)}`;

        document.getElementById('transfer-form').addEventListener('submit', function(event) {
            event.preventDefault(); 
            
            const amount = parseFloat(document.getElementById('amount').value);
            const senderBalance = parseFloat(document.getElementById('sender-balance').textContent.replace('$', '').replace(',', ''));

            if (amount <= 0) {
                document.getElementById('transfer-message').textContent = 'Amount must be greater than zero.';
                document.getElementById('transfer-message').style.display = 'block';
            } else if (amount > senderBalance) {
                document.getElementById('transfer-message').textContent = 'Insufficient balance.';
                document.getElementById('transfer-message').style.display = 'block';
            } else {
                document.getElementById('transfer-message').style.display = 'none';

                fetch('transfer_process.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        sender_name: sender.name,
                        sender_account_number: document.getElementById('sender-account-number').value,
                        receiver_name: document.getElementById('receiver-name').value,
                        receiver_account_number: document.getElementById('receiver-account-number').value,
                        amount: amount
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('transfer-message').textContent = data.error;
                        document.getElementById('transfer-message').style.display = 'block';
                    } else if (data.success) {
                        document.getElementById('transfer-success-message').innerHTML = `
                            Transfer successful.<br>
                            Your current balance: $${data.sender_balance.toFixed(2)}<br>
                            Receiver's current balance: $${data.receiver_balance.toFixed(2)}
                        `;
                        document.getElementById('transfer-success-message').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error during transfer:', error);
                    document.getElementById('transfer-message').textContent = 'An unexpected error occurred.';
                    document.getElementById('transfer-message').style.display = 'block';
                });
            }
        });
    }
});
