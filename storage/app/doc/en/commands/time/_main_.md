Gives several time-related commands to ease organization. For now this only includes a remind function but an event planner is in the works.

| Group |  Command  |       Arguments       |                         Description                          | Clearance |
| ----- | :-------: | :-------------------: | :----------------------------------------------------------: | :-------: |
|       | `remind`  | `<date> [message...]` | returns the specified message after the specified amount of time. To precise the delay before sending the message use the following format: `1d15h6m1s` where `d` stands for days, `h` for hours, `m` for minutes and `s` for seconds. The numbers preceding them must be integers and represent the number of units to wait for (be it days, hours, minutes or seconds). All other words given as argument will form the message's content and will be sent in PM to the user after the specified delay has elapsed. |     *     |
| event |  `new `   |       `<name>`        | creates a live event creation session in Direct Message (DM). The bot will ask the user to fill in the required and optional fields of `name`. |     *     |
| event |  `send`   |       `<name>`        |           Sends the event in the current channel.            |     *     |
| event |   `rm`    |       `<name>`        | Deletes the `name` event from the user’s selection of events |     *     |
| event |  `list`   |                       |        Returns the list of all events for this user.         |     *     |
| event |  `edit`   |   `<name> <field>`    |       lets the user only edit `field` for `name` event       |     *     |
| event | `preview` |       `<name>`        |          returns the current embed bound to `name`           |     *     |

