Gives several time-related commands to ease organization. For now this only includes a remind function but an event planner is in the works.

<div class="command">
  <div class="command-head" clearance="anyone">
    remind &lt;date&gt; [message...] 
  </div>
  <div class="command-desc">
    <p>Returns the specified message after the specified amount of time. To precise the delay before sending the message use the following format: `1d15h6m1s` where `d` stands for days, `h` for hours, `m` for minutes and `s` for seconds. The numbers preceding them must be integers and represent the number of units to wait for (be it days, hours, minutes or seconds). All other words given as argument will form the message's content and will be sent in PM to the user after the specified delay has elapsed.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    event new &lt;name&gt;
  </div>
  <div class="command-desc">
    <p>Creates a live event creation session in Direct Message (DM). The bot will ask the user to fill in the required and optional fields of `name`.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    event send &lt;name&gt;
  </div>
  <div class="command-desc">
    <p>Sends the event in the current channel.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    event rm &lt;name&gt;
  </div>
  <div class="command-desc">
    <p>Deletes the `name` event from the user’s selection of events.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    event list
  </div>
  <div class="command-desc">
    <p>Returns the list of all events for this user.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    event edit &lt;name&gt; &lt;field&gt;
  </div>
  <div class="command-desc">
    <p>Lets the user only edit `field` for `name` event.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    event preview &lt;name&gt;
  </div>
  <div class="command-desc">
    <p>Returns the current embed bound to `name`.</p>
  </div>
</div>

