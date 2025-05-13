{ pkgs ? import <nixpkgs> {} }:

pkgs.buildInputs = [
  pkgs.php
  pkgs.composer
  pkgs.nodejs
];
