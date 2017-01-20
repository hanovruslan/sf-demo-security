Symfony Security Demo
======

## About ##

Demo box with security component features examples

### How to start ###

The very common step for every demos in this repo is to create VM via Vagrant/Virtualbox with docker and docker-compose


You can build your own VM box or you can use [my vagrant-helper](https://github.com/hanovruslan/vagrant-helper)

```
cd /path/to/vagrant-helper \
&& ./create-box.sh sf-demo-box /path/to/this/project/vagrant
```

Vagrant does not have ability to define path to you Vagrantfile from cli option. Thats why you must change dir


Once you've created custom VM box, you can just provision or create from zero after vagrant destroy

```
vagrant up --provision
```

Then you can view\play with one of the demo

* [Guard demo](manual/guard-demo.md)
* [Voter](manual/voter-demo.md)
* [ACL](manual/acl-demo.md)
