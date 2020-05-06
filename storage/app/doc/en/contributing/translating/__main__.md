
Since `v2.0` the bot now supports translation. However these translations are not made by the maintainer of the repository ([s0lst1ce](https://github.com/s0lst1ce)) but by different individuals from the community. Hence this section explains how such people should start begin their journey. First and foremost, previous explanations apply within the applicable limit. That means that code specific notices should be ignored if you're only translating. However general [rules](#Rules) shouldn't!
As for translation itself it is recommended to use a good text editor with syntax highlighting. This is because no translation tool exists for our format (as far as we know) and that we use JSON files. A good choice would be to use [SBT3](https://www.sublimetext.com/) but any similar tool will do the trick.
Now that you're setup let's get into the real thing. You should know that all you will do, you will within the `lang` folder. As explained and developed in #73 the structure of this folder is the following:
```json
lang
 - ext1
  - help.??
  - strings.??
 - ext2
  - help.??
  - strings.??
```
Where `ext` is the name of the extension (eg: `slapping`) or `config`. As you can see each of this folder contains multiple files all named `help.??` and `strings.??`. Where `??` stands for the 2-letter language code (eg: `en` for english or `fr` for french). The `help.??` file contains the text that will be used by the help command to give information about the commands of the extension. This is organized like this:
```json
{
    "command_qualified_name": ["short description", "signature", "long_description"]
}
```
The second file, `strings.**` contains all the text that might be sent to the user by the bot and hence needs to be translated. These strings (=text) will be used directly in the source code files.
Now that you know this it will seem much easier to translate. What you have to translate are the keys, that means anything encapsulated in `"` and after the `:`.
Once you're done translating you should make a PR. We understand that translating the entire bot may be hard, and take time. Thus we allow you to translate only parts of it and propose this change. If we accept, we still need all strings to exist in all files. This means that if there's a string you have not yet translated you should put the english translation instead. If you do all this we will merge the changes. As we may not know the language you've translated to please do your best to keep the same level of language and don't start altering the meaning of the original (english) strings.
I hope this will get you started! Come and try, we're nice ;)
