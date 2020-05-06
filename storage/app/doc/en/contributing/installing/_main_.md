# Automated
To ease the whole process you can now choose to run our automated `deploy.sh` script. If so you only need to get this file from the repository, all else will be handled by the said script. This is the recommended solution.
Do note this will **not work** if you are not under a Linux system.

#Manual

If you choose not to use the script, or can't because of the platform you use, the instruction to install and use the bot are provided thereafter.

## Requirements

You will need python >= 3.7 and the library [discord.py](https://github.com/Rapptz/discord.py) >=1.3.5.

The easiest way to do this is to run the following into your shell:
`python -m pip install -r requirements.txt` (depending on your installation you may have to use the command `python3`)

# The serious stuff

Fork the repository from the [GitHub page](https://github.com/s0lst1ce/Botanist). This will make a copy of the repo on your account.

Now you need to clone the repository, you can do it using your favourite client (e.g. GitHub Desktop, GitKraken...) or you can do it using your terminal with this command:

`git clone https://github.com/s0lst1ce/Botanist.git`

Then:

`cd Botanist` 

And there you go! This is a fast [explanation](https://discordapp.com/developers/docs/intro#bots-and-apps) about how to "create" a bot form the official discord's doc. You have to make an "app" and then you'll have a token in the "Bot" section of your App you will be able to see/copy your token.

**Tokens are precious as they give full access to your bot so be careful with them!** To run the bot you first need to set the environment variable `DISCORD_TOKEN` to the value of your bot's token. Otherwise the bot won't start.

You'll also have to invite the bot on your developing server.

To run the bot you just have to execute this command in your shell: 

`python main.py`

You're now able to edit the Bot! :tada: :confetti_ball:
