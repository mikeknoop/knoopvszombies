# Knoop vs Zombies

An open source [Humans vs Zombies](http://humansvszombies.org/) game engine. Find a hosted version of this engine at [http://muzombies.org](http://muzombies.org) and [http://trumanzombies.org](http://muzombies.org).

![Knoop vs Zombies in action](http://i.imgur.com/j6ZbQDY.png)

# Install

There are a few moving pieces. The engine is currently designed to run on a LAMP stack.

1. Clone the repo to your server
2. Edit knoopvszombies.ini.php to match all your local environment settings
3. Place the `cron` file commands into your cronjob. Also update the paths in this file to match your server
4. Set up two new databases, one for the engine and one for the forums. Import the schema from the two `.sql` files in the root folder
5. (You may need to do more work to get the forums set up properly, a starting point is the Vanilla docs: http://vanillaforums.org/docs/installation)
6. Emails are sent out using the standard PHP email mechanisms so make sure you have all the proper rigging to send emails without them getting flagged as spam.

# Motivation

Running the game at the University of Missouri, we indentified several flaws around the game and engine that could be rectified with an improved game engine. This engine introduces several features that assist in running a Humans vs. Zombies game from a player standpoint and a moderator (admin) standpoint.

# Questions

Email me: mikeknoop@gmail.com I'll be happy to help!

# Overview

Once all the tech is up and running, as an admin, you should create your first game from the admin panel. Set it for the future sometime. You can also set up orientation times and locations. Make sure to check "current" after creating your game to set it as the current game if you intend for players to join it now.

As players sign up, they will asked to conform to a code of conduct and sign a digital waiver before being allowed to play. If they choose to link their account to Facebook, they will be auto-confirmed (motivation: getting a real name and photo). If they choose to manually enter their name and photo, they will have to be approved by a moderator.

The game is in "pre game" mode. During this time, players can sign up and join the upcoming game. They can get their code and opt-into the Original Zombie pool if they'd like. Moderators can approve players, mark players having attended an orientation, send out email, and choose original zombies.

Automatically, the game will begin at the date and time the moderator originally chose for the game (CST time by deafult, change in knoopvszombies.ini.php). At this time, the game goes into "in game" mode. All players who were marked as having attended an orientation will be kept alive. Any player who did not attend an orientation will be marked as deceased. Original Zombies are shown as humans on the website until the moderators decide to unhide original zombies through the "Game Progress" admin panel (see below).

The game continues for several days. Every 5 minutes (a cron job, `game_logic.php`) is run to check if anyone is about to die because they haven't been "fed" in 48 (configurable) hours. As zombie players enter codes to confirm kill, the human is automatically marked as a zombie and notified via email, and the reporting zombie will be fed and can feed two other players from a list.

Finally, everone is a zombie or the moderators end the game through a story element. The gameplay progress is manually moved into "post game" by a moderator. At this time, all stats are locked and the game is archived. Moving the game into "post game" cannot be undone.

The last thing for the moderators to do is uncheck "current" for the current game from the "Create Game" admin control panel. This will set the site to a neutral tone, suitable for the time inbetween one game ending and the next being announced.

# Features

## Global user accounts

- Players can use a single user account to join multiple games
- Stats carry over from previous games
- Digital code of conduct and waiver signing during the signup flow
- Signup with Facebook for verified photo and name association
- Manual account approval without Facebook verification

## Fully-stocked admin panel

### Orientation Tool
A high-speed typeahead to mark players who have attended an oritentation session. Optimized for en-masse approving players -- for when you have three moderators trying to approve 200 people at your orientation.

![Orientation Tool](http://i.imgur.com/TlCwHgk.png)

### Edit Current Player
A "player" is a user who has joined the currently available game. Edit details about any player for the current game. From code to kills to zombie status.

![Edit Player](http://i.imgur.com/Eo4EKf6.png)

### Edit User
Edit user accounts (these persist between games) to promote people to moderators, remove or add them to a game, and update other various details. There are several priviledges each user can have and what admin tools they have access to. 

![Edit User](http://i.imgur.com/SbMmCkC.png)

### User Approval
By default, if a user signs up and connects their account to Facebook they will be automatically approved. Otherwise, they will need to be manually approved by a moderator before being allowed to join a game. This is mostly to ensure players have a real name and a real photo.

![Approval](http://i.imgur.com/QKpwwEE.png)

### Gameplay Progress
This tool lets head moderators move the game from one state to the next (pre game, in game, post game). Game choose Original Zombies here and manually open and close registration.

![Gameplay](http://i.imgur.com/2T4gV8l.png)

### Send Email
Send emails to the entire userbase or just the current players. Or just humans, or just zombies. Sends from your own SMTP server so you'll have to do the work to get that set up properly.

![Email](http://i.imgur.com/kYaa6o6.png)

### Create Game
An interface to create and edit upcoming games. Name the game, set start date and time, and choose orientation locations and times.
 
![Create Game](http://i.imgur.com/YXhlB1n.png)

## Social Media Tie-ins

- Post game status and kills to a Twitter feed
- Bring Facebook posts onto the homepage

## Forums

- In house forums that have "human only" and "zombie only" forums for communication.

![Forums](http://i.imgur.com/CLcZj2E.png)

# License

Knoop vs Zombies is available under the MIT license.