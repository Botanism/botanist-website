Allows the developers to update the bot and notify all server owners of the changes. It also facilitates bug fixing by providing an easy way to retrieve the log.

<div class="command">
  <div class="command-head" clearance="runner">
    update [message...]
  </div>
  <div class="command-desc">
    <p>Sends an update message to all users who own a server of which the bot is a member. `message` will be transformed into the message sent to the server owners. A default message is sent if none is provided. This can be modified in `settings.py`.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="runner">
    log
  </div>
  <div class="command-desc">
    <p>Returns the bot's log file.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    dev
  </div>
  <div class="command-desc">
    <p>Sends the development server URL to the author of the message.</p>
  </div>
</div>