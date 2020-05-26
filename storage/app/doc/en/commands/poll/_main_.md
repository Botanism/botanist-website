This suite of commands provides automatic poll creation. A poll is an embed message sent by the bot to specified channels. Every user can react to the poll to show their opinion regarding the interrogation submitted by the poll. With each reaction, the poll's color will change to give everyone a quick visual feedback of all members' opinion. A poll is generated from a user's message. Currently it only supports messages from a `poll` channel. However it is planned to improve this to allow one to create a poll using a dedicated command. Same goes for poll editing which is yet unsupported. To palliate to this you can remove your poll if you consider it was malformed. Polls can also be deleted when reacting with the `:x:` emoji.

<div class="command">
  <div class="command-head" clearance="anyone">
    poll rm &lt;msg_ig&gt;
  </div>
  <div class="command-desc">
    <p>If the user is the author of the poll with the `msg_id` message, the bot deletes the specified poll.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    poll status
  </div>
  <div class="command-desc">
    <p>:warning: DEPRECATED :warning: Returns stats about your active polls. This is also called when one of you poll gets deleted.</p>
  </div>
</div>

<div class="command">
  <div class="command-head" clearance="anyone">
    poll extended &lt;description...&gt; &lt;choices...&gt;
  </div>
  <div class="command-desc">
    <p>This command creates polls that can have more than the 3 standard reaction but do not support dynamic color. The way to make one is to be write the following command in a poll channel (message discarded otherwise). The message is composed of the description then a line break then, one each following line: an emoji followed by a description each of these lines are separated by a line break.</p>
  </div>
</div>