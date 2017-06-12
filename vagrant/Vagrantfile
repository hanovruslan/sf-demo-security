# -*- mode: ruby -*-
# vi: set ft=ruby :

require "yaml"
settings = YAML.load_file File.expand_path("settings.yml", File.dirname(__FILE__))
Vagrant.configure(2) do |config|
    config.vm.define settings["name"] do |box|
        box.vm.box = settings["box"]
        box.vm.hostname = settings["name"]
        box.vm.provider :virtualbox do |provider|
            provider.name = settings["name"]
        end
        box.vm.network :private_network, ip: settings["ip"]
        box.vm.synced_folder ".", "/vagrant", "type": :nfs
    end
end
