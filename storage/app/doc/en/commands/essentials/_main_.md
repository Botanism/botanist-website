This extension contains some of the most basic managing commands and should almost always be enabled.

<div class="command">
  <div class="command-head" clearance="anyone">
    ping
  </div>
  <div class="command-desc">
    <p>replies with the rounded latency of the message transfer</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="runner">
    shutdown
  </div>
  <div class="command-desc">
    <p>shuts down the bot properly</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="manager">
    clear [nbr] [period] [members...]
  </div>
  <div class="command-desc">
    <p>this command lets one delete messages from a channel. The provided arguments are filters that will be applied to the messages selection process. `nbr` specifies the maximum number of messages that should be deleted. If not given then there is no maximum, **be careful with it**. This will always be respected although less messages may get deleted if `period` doesn't contain enough messages. `period` represents a time frame. The bot will look for all messages within this time frame. It should be constructed like `remind`. All messages which were sent between *now* and `period` will get deleted unless this represents more messages than `nbr`. `members...` is a list of server members. Only messages from these users will get deleted. You do not need to pass any of the arguments to the command and can pass any combination of them to the command. However they **must** be given in order!</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    status
  </div>
  <div class="command-desc">
    <p>returns some statistics and info about the server and its members</p>
  </div>
</div>