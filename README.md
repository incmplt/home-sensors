# Home sensor on RaspberryPi 3/4

このプロジェクトは、RaspberryPi に簡易的なセンサーを追加して自宅のコンディションを監視する目的で作成したコード群である。

## Description

## Requirement

本環境は、以下のハードウェアで構成している。

* RaspberryPi 3B or 4
* BME230
* MH-Z19
* Network Connection
* Option: Google Home

![Home Sensors](/doc/RaspberryPi-HomeSensors.png)

RaspberryPi ZARO (WH)では、MH-Z19 の Co2 取得が上手くいかない場合があった。
推奨は、RaspberryPi 3 もしくは 4 とする。

## Usage

```bash
sudo python3 /opt/iot/bin/saveSensors.py
```

## Install

```bash
make install
```

## Optional

## Licence

[MIT](https://github.com/tcnksm/tool/blob/master/LICENCE)

## Author

* [incmplt](https://www.incmplt.net/)
* [Info Circus,Inc.](https://www.infocircus.jp/)
