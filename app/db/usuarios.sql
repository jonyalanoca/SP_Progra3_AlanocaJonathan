-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-03-2021 a las 21:21:28
-- Versión del servidor: 8.0.13-4
-- Versión de PHP: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cripto_db`
--

-- --------------------------------------------------------
create table if not EXISTS criptomonedas(
	idCripto int AUTO_INCREMENT,
    PRIMARY KEY(idCripto),
    nombre varchar(50),
    precio decimal(10,2),
    foto varchar(100),
    nacionalidad varchar(100)  
);
create table if not EXISTS usuarios(
    idUsuario int AUTO_INCREMENT,
    PRIMARY KEY(idUsuario),
    email varchar(100),
    clave varchar(150),
    tipo varchar(50)
)AUTO_INCREMENT= 1000;
create table if not EXISTS ventas(
	idVenta int AUTO_INCREMENT,
    PRIMARY KEY(idVenta),
    id_Cripto int,
    id_Usuario int,
    fecha date,
    cantidad int,
    imagen varchar(100)
)AUTO_INCREMENT=2000;

ALTER TABLE usuarios ADD nombre varchar(50);

/*Creacion de un socio para pruebas:*/;
/*Autentificacion- email:jonathanAdmin@gmail.com clave:jonathanAdmin*/;
insert into socios(nombre, email, tipo, clave)values('jonathan','jonathanAdmin@gmail.com','admin', '$2y$10$Mr0ohrO0pfDqmSgKjpPBM.dhgzmukggIhKVgwZDD7eAyulJ.ZOJr6');
