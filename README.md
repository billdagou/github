# TYPO3 Extension: Github

The EXT:github extension can save your time when some event is triggered in your GitHub repository with the Webhooks feature.

### Why This

Generally, you can run `git pull` to update the extensions cloned from Github, or maybe upgrade them via TER. However, supposing you have many websites/projects which are using some same extensions/repositories in different servers, like some great extensions EXT:fluidpages, EXT:vhs and etc, you have to upgrade all of them one website/project by one website/project, and one server by one server.

With this extension, all you need is to setup the Webhooks in your repository settings.

### Known Issues

- The value of the `secret` field doesn't change after its first run until you clear the caches.