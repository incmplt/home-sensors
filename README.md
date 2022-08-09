# Home sensor on RaspberryPi 3/4

このプロジェクトは、RaspberryPi に簡易的なセンサーを追加して自宅のコンディションを監視する目的で作成したコード群である。

## Description

本ソースコードのハードウェア準備については、以下のWEBページを参照。
Reference: [RaspberryPi Sensors : incmplt Site](https://www.incmplt.net/2021/06/27/raspberrypi-sensors/)

## Requirement

本環境は、以下のハードウェアで構成している。

* RaspberryPi 3B or 4
* BME280
* MH-Z19
* python3
* Network Connection
* Option: Google Home

![Home Sensors](/doc/RaspberryPi-HomeSensors.png)

RaspberryPi ZARO(WH) では、MH-Z19 の Co2 取得が上手くいかない場合があった。
推奨は、RaspberryPi 3 もしくは 4 とする。

また、ネットワークの通信は wlan0 を想定してスクリプトを作成している。
サーバーの通知機能を wlan0 以外で使用する場合には、スクリプトの値を変更する必要がある。

## Usage

```bash
sudo python3 /opt/iot/bin/saveSensors.py
```

## Install

RaspberryPi の シリアルポートを使用するため、Raspi-configでシリアルポートを有効にしておく。

```bash
sudo raspi-config
```

* 3 Interface Options
* P6 Serial Port

以下のパッケージを準備する。

```bash
sudo apt install python3
sudo apt install i2c-tools
sudo pip3 install mh-z19
```

i2c-tools をインストールしたら、Linux Industrial I/O Subsystem (Linux IIO) を使用できるようにするために、/boot/config.txt に以下の行を追加する。

```text
dtoverlay=i2c-sensor,bme280
```

設定を追加したら有効にするために再起動する。
再起動後に以下のコマンドを実行し BME280 を認識しているかを確認する。

```bash
pi@raspberrypi:~ $ cat /sys/bus/iio/devices/iio\:device0/name
bme280
```

環境の構築は make コマンドを使用する。

```bash
make install
```

## Optional

## Licence

[MIT](https://github.com/tcnksm/tool/blob/master/LICENCE)

## Author

* [incmplt](https://www.incmplt.net/)
* [Info Circus,Inc.](https://www.infocircus.jp/)
