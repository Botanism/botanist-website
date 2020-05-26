priority: 2
[----]
A suite of commands always activated which handle extension management. This cannot be unloaded as it is part of the core of the bot and is required for live updates.

<div class="command">
  <div class="command-head" clearance="runner">
    ext add &lt;extensions...&gt;
  </div>
  <div class="command-desc">
    <p>Loads the  specified `extensions` bot extensions. If the command fails the bot will continue to run without the extension.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="runner">
    ext rm &lt;extensions...&gt;
  </div>
  <div class="command-desc">
    <p>Removes the  specified `extensions` bot extensions. If the command fails the bot will continue to run with the extension.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="runner">
    ext reload &lt;extensions...&gt;
  </div>
  <div class="command-desc">
    <p>Reloads the  specified `extensions` bot extensions. If the command fails the extension will stay unloaded.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="runner">
    ext ls
  </div>
  <div class="command-desc">
    <p>Returns an embed with all the extensions and their status.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    help [page]
  </div>
  <div class="command-desc">
    <p>Initiates an interactive help session. If a `page` is supplied then it opens it only for this page and subpages. A page can be a cog, group or command. For more on this see the FAQ entry on how to use help.</p>
  </div>
</div>


