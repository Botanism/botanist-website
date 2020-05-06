A suite of commands always activated which handle extension management. This cannot be unloaded as it is part of the core of the bot and is required for live updates.

| Group | Command  |   Arguments   |                         Description                          | Clearance |
| ----- | :------: | :-----------: | :----------------------------------------------------------: | --------- |
| `ext` |  `add`   | `<extension>` | loads the  specified `extension` bot extension. If the command fails the bot will continue to run without the extension. | runner    |
| `ext` |   `rm`   | `<extension>` | removes the  specified `extension` bot extension. If the command fails the bot will continue to run with the extension. | runner    |
| `ext` | `reload` | `<extension>` | reloads the  specified `extension` bot extension. If the command fails the extension will stay unloaded | runner    |
| `ext` |   `ls`   |               |  returns an embed with all the extensions and their status   | runner    |
|       |  `help`  |   `[page]`    | initiates an interactive help session. If a `page` is supplied then it opens it only for this page and subpages. A page can be a cog, group or command. | *         |