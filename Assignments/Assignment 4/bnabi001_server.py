#!/usr/bin/env python3
# See https://docs.python.org/3.2/library/socket.html
# for a description of python socket and its parameters
import socket
import webbrowser
from threading import Thread
from argparse import ArgumentParser

BUFSIZE = 4096

def client_talk(client_sock, client_addr):
    while True:
        print('talking to {}'.format(client_addr))
        try:
            data = client_sock.recv(BUFSIZE)
        except:
            f = open('bad_request.html') #I change the name of the file because %r is not readable
            outputdata = f.read()
            client_sock.send('HTTP Error 400 Bad Request\nContent-Type: text/html\n\n')
            for i in range(0, len(outputdata)):
                client_sock.send(outputdata[i])
            client_sock.close()
        try:
            #data = client_sock.recv(BUFSIZE)
            method = data.split()[0]
            if method == 'GET':
                try:
                    filename = data.split()[1]
                    f = open(filename[1:])
                    outputdata = f.read()
                    webbrowser.open_new_tab(filename)
                    client_sock.send('HTTP/1.1 200 OK\nContent-Type: text/html\n\n')
                    for i in range(0, len(outputdata)):
                        client_sock.send(outputdata[i])
                    client_sock.close()
                except :
                    f = open('404.html')
                    outputdata = f.read()
                    client_sock.send('HTTP Error 404 Not Found\nContent-Type: text/html\n\n')
                    for i in range(0, len(outputdata)):
                        client_sock.send(outputdata[i])
                    client_sock.close()
            #    except:
            #        f = open('406.html')
            #        outputdata = f.read()
            #        client_sock.send('HTTP Error 406 Not Acceptable\nContent-Type: text/html\n\n')
            #        for i in range(0, len(outputdata)):
            #            client_sock.send(outputdata[i])
            #        client_sock.close()
            elif method == 'HEAD':
                try:
                    f = open('202.html')
                    outputdata = f.read()
                    client_sock.send('HTTP/1.1 200 OK\nContent-Type: text/html\n\n')
                    for i in range(0, len(outputdata)):
                        client_sock.send(outputdata[i])
                    client_sock.close()
                except:
                    f = open('404.html')
                    outputdata = f.read()
                    client_sock.send('HTTP Error 404 Not Found\nContent-Type: text/html\n\n')
                    for i in range(0, len(outputdata)):
                        client_sock.send(outputdata[i])
                    client_sock.close()
            elif method =='POST':
                f = open('private.html')
                inputdata = """<html>
                  <head>
                    <title> Private File </title>
                    <link rel="stylesheet" type="text/css" href="style.css">
                  </head>
                  <body>
                    <h1> Following form Submitted succefully </h1>
                    <table>
                      <tr>
                          <td id = "eventname"> event name: </td>
                          <td> </td>
                      </tr>
                      <tr>
                          <td id = "starttime"> start time: </td>
                          <td> </td>
                      </tr>
                      <tr>
                          <td id = "endtime"> end time: </td>
                          <td> </td>
                      </tr>
                      <tr>
                          <td id = "location"> location: </td>
                          <td> </td>
                      </tr>
                      <tr>
                          <td id = "day"> day: </td>
                          <td> </td>
                      </tr>
                    </table>
                  </body>
                </html> """
                outputdata = f.writ(inputdata)
                f.close()
                client_sock.close()
            else:
                f = open('405.html')
                outputdata = f.read()
                client_sock.send('HTTP Error 405 Method Not Found\nContent-Type: text/html\n\n')
                for i in range(0, len(outputdata)):
                    client_sock.send(outputdata[i])
                client_sock.close()
        except:
            f = open('403.html')
            outputdata = f.read()
            client_sock.send('HTTP Error 403 Forbidden\nContent-Type: text/html\n\n')
            for i in range(0, len(outputdata)):
                client_sock.send(outputdata[i])
            client_sock.close()


    # clean up
    client_sock.shutdown(1)
    client_sock.close()
    print('connection closed.')

class EchoServer:
  def __init__(self, host, port):
    print('listening on port {}'.format(port))
    self.host = host
    self.port = port

    self.setup_socket()

    self.accept()

    self.sock.shutdown()
    self.sock.close()

  def setup_socket(self):
    self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    self.sock.bind((self.host, self.port))
    self.sock.listen(128)

  def accept(self):
    while True:
      (client, address) = self.sock.accept()
      th = Thread(target=client_talk, args=(client, address))
      th.start()

def parse_args():
  parser = ArgumentParser()
  parser.add_argument('--host', type=str, default='localhost',
                      help='specify a host to operate on (default: localhost)')
  parser.add_argument('-p', '--port', type=int, default=9001,
                      help='specify a port to operate on (default: 9001)')
  args = parser.parse_args()
  return (args.host, args.port)


if __name__ == '__main__':
  (host, port) = parse_args()
  EchoServer(host, port)

