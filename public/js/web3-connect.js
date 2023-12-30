document.addEventListener("DOMContentLoaded", function () {
    const connectButton = document.getElementById("connectButton");
    const connectedAddressContainer = document.getElementById(
        "connectedAddressContainer"
    );
    const connectedAddressElement = document.getElementById("connectedAddress");

    if (window.ethereum) {
        window.web3 = new Web3(window.ethereum);
        connectButton.addEventListener("click", async () => {
            try {
                // Request account access if needed
                await window.ethereum.enable();
                console.log("Connected to MetaMask");

                // Now you can use web3 to interact with Ethereum

                // Example: Get accounts
                const accounts = await window.web3.eth.getAccounts();
                const connectedAddress = accounts[0];

                // Save connected address to session via Laravel route
                await fetch("/connect-metamask", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify({ connectedAddress }),
                });

                console.log("Connected account:", connectedAddress);

                // Update UI to display the connected address
                updateUI(connectedAddress);
            } catch (error) {
                console.error("MetaMask connection error:", error);
            }
        });
    } else {
        console.error("MetaMask not installed");
    }

    function updateUI(connectedAddress) {
        // Hide connect button
        connectButton.style.display = "none";

        // Display connected address
        connectedAddressElement.textContent =
            formatConnectedAddress(connectedAddress);
        connectedAddressContainer.style.display = "inline";
    }

    function formatConnectedAddress(address) {
        // Format the address (e.g., show only the first and last few characters)
        const truncatedAddress = `${address.substring(
            0,
            6
        )}...${address.substring(address.length - 4)}`;
        return truncatedAddress;
    }
});
