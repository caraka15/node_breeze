# Setup for Mainnet planq

 <img width="468" alt="Screenshot 2022-12-31 133454" src="https://user-images.githubusercontent.com/108979536/210136942-caa7f157-c189-4d6b-8278-0bb86f42ba2c.png">

### Guide Source :

- Planq Network
- Explorer:

https://explorer.planq.network

# Hardware Requirements

Like any Cosmos-SDK chain, the hardware requirements are pretty modest.

- Minimum Hardware Requirements

4x CPUs; the faster clock speed the better

8GB RAM

100GB of storage (SSD or NVME)

### Recommended Hardware Requirements

- 8x CPUs; the faster clock speed the better
- 64GB RAM
- 1TB of storage (SSD or NVME)

# Set up your Planq Validator

### Option 1 (automatic)

You can setup your planq validator in few minutes by using automated script below. It will prompt you to input your validator node name!

    wget -O planq.sh https://raw.githubusercontent.com/appieasahbie/planq/main/planq.sh && chmod +x planq.sh && ./planq.sh

### Post installation

When installation is finished please load variables into system

    source $HOME/.bash_profile

Next you have to make sure your validator is syncing blocks. You can use command below to check synchronization status

    planqd status 2>&1 | jq .SyncInfo

### Create wallet

- To create new wallet you can use command below. Don’t forget to save the mnemonic

      planqd keys add $WALLET

(OPTIONAL) To recover your wallet using seed phrase

      planqd keys add $WALLET --recover

- (import your wallet from metamask)

      planqd keys unsafe-import-eth-key <wallet-name> <private-key-eth> --keyring-backend file

- To get current list of wallets

      planqd keys list

(Save wallet info in your notepad)

### Add wallet and valoper address into variables

    PLANQD_WALLET_ADDRESS=$(planqd keys show $WALLET -a)
    PLANQD_VALOPER_ADDRESS=$(planqd keys show $WALLET --bech val -a)
    echo 'export PLANQD_WALLET_ADDRESS='${PLANQD_WALLET_ADDRESS} >> $HOME/.bash_profile
    echo 'export PLANQD_VALOPER_ADDRESS='${PLANQD_VALOPER_ADDRESS} >> $HOME/.bash_profile
    source $HOME/.bash_profile

### Fund your wallet

In order to create validator first you need to fund your wallet with mainnet tokens please refer to this guide : https://docs.planq.network/about/airdrop.html to get mainnet tokens and import your wallet from metamask read above

### Create validator

Before creating validator please make sure that you have at least 1 planq (1 planq is equal to 1000000000000 aplanq) and your node is synchronized

- To check your wallet balance:

      planqd query bank balances $PLANQD_WALLET_ADDRESS

If your wallet does not show any balance than probably your node is still syncing. Please wait until it finish to synchronize and then continue

To create your validator run command below

    planqd tx staking create-validator \
     --amount 1000000000000aplanq \
     --from $WALLET \
     --commission-max-change-rate "0.01" \
     --commission-max-rate "0.2" \
     --commission-rate "0.05" \
     --min-self-delegation "1" \
     --pubkey  $(planqd tendermint show-validator) \
     --moniker $NODENAME \
     --chain-id $PLANQ_CHAIN_ID \
     --gas="1000000" \
     --gas-prices="30000000000aplanq" \
     --gas-adjustment="1.15"

### Security

To protect you keys please make sure you follow basic security rules

Set up ssh keys for authentication
Good tutorial on how to set up ssh keys for authentication to your server can be found here

- Basic Firewall security
  Start by checking the status of ufw.

       sudo ufw status

- Sets the default to allow outgoing connections, deny all incoming except ssh and 26656. Limit SSH login attempts

       sudo ufw default allow outgoing
       sudo ufw default deny incoming
       sudo ufw allow ssh/tcp
       sudo ufw limit ssh/tcp
       sudo ufw allow ${PLANQ_PORT}656,${PLANQ_PORT}660/tcp
       sudo ufw enable

### Check your validator key

        [[ $(planqd q staking validator $PLANQD_VALOPER_ADDRESS -oj | jq -r .consensus_pubkey.key) = $(planqd status | jq -r .ValidatorInfo.PubKey.value) ]] && echo -e     "\n\e[1m\e[32mTrue\e[0m\n" || echo -e "\n\e[1m\e[31mFalse\e[0m\n"

- Get list of validators

        planqd q staking validators -oj --limit=3000 | jq '.validators[] | select(.status=="BOND_STATUS_BONDED")' | jq -r '(.tokens|tonumber/pow(10; 6)|floor|tostring) + " \t " + .description.moniker' | sort -gr | nl

### Usefull commands

- Service management
  Check logs

        journalctl -fu planqd -o cat

- Start service

      sudo systemctl start planqd

- Stop service

      sudo systemctl stop planqd

- Restart service

      sudo systemctl restart planqd

### Node info

- Synchronization info

      planqd status 2>&1 | jq .SyncInfo

- Validator info

      planqd status 2>&1 | jq .ValidatorInfo

- Node info

      planqd status 2>&1 | jq .NodeInfo

- Show node id

      planqd tendermint show-node-id

### Wallet operations

- List of wallets

      planqd keys list

- Recover wallet

      planqd keys add $WALLET --recover

- Delete wallet

      planqd keys delete $WALLET

- Get wallet balance

      planqd query bank balances $PLANQD_WALLET_ADDRESS

- Transfer funds

      planqd tx bank send $PLANQD_WALLET_ADDRESS <TO_PLANQ_WALLET_ADDRESS> 1000000000000aplanq

- Voting

      planqd tx gov vote 1 yes --from $WALLET --chain-id=$PLANQ_CHAIN_ID

### Staking, Delegation and Rewards

- Delegate stake

      planqd tx staking delegate $PLANQD_VALOPER_ADDRESS 1000000000000aplanq --from=$WALLET --chain-id=$PLANQ_CHAIN_ID --gas=auto

- Redelegate stake from validator to another validator

      planqd tx staking redelegate <srcValidatorAddress> <destValidatorAddress> 1000000000000aplanq --from=$WALLET --chain-id=$PLANQ_CHAIN_ID --gas=auto

- Withdraw all rewards

      planqd tx distribution withdraw-all-rewards --from=$WALLET --chain-id=$PLANQ_CHAIN_ID --gas=auto

- Withdraw rewards with commision

      planqd tx distribution withdraw-rewards $PLANQD_VALOPER_ADDRESS --from=$WALLET --commission --chain-id=$PLANQ_CHAIN_ID

### Validator management

- Edit validator

       planqd tx staking edit-validator \
        --moniker=$NODENAME \
        --identity=<your_keybase_id> \
        --website="<your_website>" \
        --details="<your_validator_description>" \
        --chain-id=$PLANQ_CHAIN_ID \
        --from=$WALLET

- Unjail validator

      planqd tx slashing unjail \
        --broadcast-mode=block \
        --from=$WALLET \
        --chain-id=$PLANQ_CHAIN_ID \
        --gas=auto

- Delete node
  This commands will completely remove node from server. Use at your own risk!

         sudo systemctl stop planqd && \
         sudo systemctl disable planqd && \
         rm /etc/systemd/system/planqd.service && \
         sudo systemctl daemon-reload && \
         cd $HOME && \
         rm -rf planqd && \
         rm -rf .planqd && \
         rm -rf $(which planqd)
