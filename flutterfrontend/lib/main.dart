import 'package:flutter/material.dart';
import 'package:flutterfrontend/core/theme/theme.dart';
import 'package:flutterfrontend/src/screeens/signup.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Blog App',
      theme: AppTheme.darkThemeMode,
      home: const SignUpPage(),
    );
  }
}