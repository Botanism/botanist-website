Allows moderators to give quick and light warnings to disrespectful members. By slapping a member he gets notified of his misbehavior and knows who did it. Both the administrator and the user can see his/her slap count. The slap count is also cross-server.

<div class="command">
  <div class="command-head" clearance="manager">
    slap &lt;member&gt; [reason...] 
  </div>
  <div class="command-desc">
    <p>slaps the specified `member` member one time. The other arguments will form the optional reason for the slap.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="manager">
    forgive &lt;member&gt; [number] 
  </div>
  <div class="command-desc">
    <p>forgives the specified `member` member `nbr` number of time(s). If `nbr` is unspecified, pardons the member of all his slaps. Member can be a mention, a user id or just the string of the name of the member.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="manager">
    slaps [members...]
  </div>
  <div class="command-desc">
    <p>returns an embed with a list of all slapped members and their slap count. If arguments are given they must represent members or their ids/name. If so detailed info will be returned only of those members. It gives access to the slapping log.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="manager">
    mute &lt;member&gt;&lt;time&gt;
  </div>
  <div class="command-desc">
    <p>mutes `member` in the current channel for `time` period. This prevents the user to send messages in the channel.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    abuse &lt;member&gt; [reason...]
  </div>
  <div class="command-desc">
    <p>sends a report card with `reason` description about `member` to the set moderation channel so that moderators can deal with it</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    spam &lt;member&gt;
  </div>
  <div class="command-desc">
    <p>increases spam count of `member` by one. Once the counter reaches the the server threshold, the user is muted for 10 minutes.</p>
  </div>
</div>