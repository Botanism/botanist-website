priority: 1
[----]
This section of the user documentation contains an exhaustive list of all extensions and the commands they provide. This list is kept up to date with the latest updates. Some commands can only be ran in a server (ie: you can't have roles in a DM). They are also all case sensitive. To make you message a command it must start with the set `PREFIX`. By default this is set to `::`. This means that if you want to call the command `slaps`, you have to enter `::slaps`. The prefix is not mentioned in the following reference.

   Those commands are sometimes regrouped under a **group**. This means that a command belonging to a **group** will only be recognized if the **group**'s name is appended before the command. For example the command `ls` of group `ext` needs to be called like this: `ext ls`.

   To prevent abuse a **clearance** system is included with the bot. This allows servers to limit the use of certain commands to select group of members. One member can possess multiple roles (ie: levels of clearance). The implemented level of clearances are listed & described in the following table in order of magnitude:

| Clearance     | Description                                                  |
| ------------- | ------------------------------------------------------------ |
| *             | this represents the wildcard and means everyone can use the command. No matter their roles |
| runner        | this role is assigned to only one member: the one with the [`RUNNER_ID`](https://github.com/organic-bots/ForeBot/blob/master/settings.py#15). This is defined in the `settings.py` file and should represent the ID of the user responsible for the bot. It is also the only cross-server role. |
| owner         | this role is automatically assigned to every server owner. It is however server-specific. It gives this member supremacy over all members in his/her server. |
| administrator | this role gives access to all server commands except the bot configuration ones |
| manager       | this role gives access to message management, warnings issues and other server moderation commands |

   Arguments (aka: parameters) are referenced in `<` & `>` in this reference although using those symbols isn't necessary when using the commands.  Some arguments are optional. If it's the case they are preceded by a `*`. Otherwise the command's list of required arguments is to be  like this: `<arg1>` `<arg2>`.  This can also be blank when the command doesn't require any argument.

 Sometimes commands require a `*` argument. This means that the argument length is unlimited. It can range from 0 to 2000 characters (the maximum allowed by discord).

Finally arguments which are not `*` but comprises spaces need to be put in quotes like this: `"this is one argument only"`. Else each "word" will be considered a different argument. If the argument count doesn't exactly match then the command will fail. Also the arguments order matters.


