-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 20, 2013 at 11:31 AM
-- Server version: 5.1.30
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jst-ta`
--

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE IF NOT EXISTS `gejala` (
  `Kd_Gejala` varchar(5) NOT NULL,
  `Nama_Gejala` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gejala`
--


-- --------------------------------------------------------

--
-- Table structure for table `gejala_penyakit`
--

CREATE TABLE IF NOT EXISTS `gejala_penyakit` (
  `Kd_Penyakit` varchar(5) NOT NULL,
  `Kd_Gejala` varchar(5) NOT NULL,
  `Nama_Gejala` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gejala_penyakit`
--


-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE IF NOT EXISTS `penyakit` (
  `Kd_Penyakit` varchar(5) NOT NULL,
  `Nama_Penyakit` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penyakit`
--


-- --------------------------------------------------------

--
-- Table structure for table `penyebab`
--

CREATE TABLE IF NOT EXISTS `penyebab` (
  `Kd_Penyebab` varchar(5) NOT NULL,
  `Nama_Penyebab` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penyebab`
--


-- --------------------------------------------------------

--
-- Table structure for table `penyebab_penyakit`
--

CREATE TABLE IF NOT EXISTS `penyebab_penyakit` (
  `Kd_Penyakit` varchar(5) NOT NULL,
  `Kd_Penyebab` varchar(5) NOT NULL,
  `Nama_Penyebab` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penyebab_penyakit`
--


-- --------------------------------------------------------

--
-- Table structure for table `solusi`
--

CREATE TABLE IF NOT EXISTS `solusi` (
  `Kd_Solusi` varchar(5) NOT NULL,
  `Nama_Solusi` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `solusi`
--


-- --------------------------------------------------------

--
-- Table structure for table `solusi_penyakit`
--

CREATE TABLE IF NOT EXISTS `solusi_penyakit` (
  `Kd_Penyakit` varchar(5) NOT NULL,
  `Kd_Solusi` varchar(5) NOT NULL,
  `Nama_Solusi` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `solusi_penyakit`
--

