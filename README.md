# Device Manager

Small businesses face all sorts of problems, both big and small.  Device Manager was created in response to a common problem within small-medium sized businesses: who has the laptop with PowerPoint 2010 on it?  There are larger scale Mobile Device Management solutions provided by all the top tier technology companies, but these can be expensive and enforce requirements which may not align with your current business goals.

Enter: Device Manager (DM).

## Why DM?

DM takes a more manual approach to managing multiple devices, and as such is intended for businesses with < 50 employees.  Staff would be required to ensure they check out devices when they get it and check them back in (to a central location, likely the IT department) when they're done.  They can file tickets on their devices if something goes wrong, track who has what laptop/phone/desktop PC and even see how their support requests stack up against their fellow coworkers (a high number of WONTFIX tickets results in a lower ranking, more COMPLETED tickets increases it).

Also, it's free.

## Features in point form

* Per-device task tracking with many basic task management functions
* Check devices in or out
* Reserve devices checked out by other users
* Full device history which tracks all actions performed on a device (check in's/out's, tasks updated, applications installed, etc.)
* Easy administration of devices, users, tasks and tracked applications.

## Requirements

* PHP >= 5.3.28
* MySQL > 5.5

## Planned Features

* 1.1
	* Usergroup Management. 
* 1.2
	* Device Watchlist.  Users choose any number of already tracked applications from a list and are presented with a list of devices which have those applications installed.
	* More flexibility in what DM can track.  Currently there are 4 types: laptops, desktops, servers and peripherals.  The plan is to make this a dynamic list of devices or items that you've chosen.

## Disclaimer

This is project is still under development and should be treated as a beta-level product.  Please use the provided issue tracker to raise issues.